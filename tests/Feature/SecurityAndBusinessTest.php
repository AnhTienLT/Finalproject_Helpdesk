<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Priority;
use App\Models\Room;
use App\Models\Ticket;
use App\Models\TicketStatusLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityAndBusinessTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    protected function user(string $roleName): User
    {
        return User::whereHas('role', fn ($q) => $q->where('name', $roleName))->first();
    }

    // S2: User thường KHÔNG được xoá phòng
    public function test_regular_user_cannot_delete_room(): void
    {
        $user = $this->user('User');
        $room = Room::create(['name' => 'Test', 'location' => 'X']);
        $this->actingAs($user)
            ->delete(route('rooms.destroy', $room))
            ->assertForbidden();
        $this->assertDatabaseHas('rooms', ['id' => $room->id]);
    }

    // S2: Admin XOÁ được phòng (không có ràng buộc)
    public function test_admin_can_delete_empty_room(): void
    {
        $admin = $this->user('Admin');
        $room = Room::create(['name' => 'Room X', 'location' => 'Y']);
        $this->actingAs($admin)
            ->delete(route('rooms.destroy', $room))
            ->assertRedirect(route('rooms.index'));
        $this->assertDatabaseMissing('rooms', ['id' => $room->id]);
    }

    // S1: User A không được phản hồi vào ticket của User B
    public function test_user_cannot_respond_to_others_ticket(): void
    {
        $userA = User::where('email', 'user@helpdesk.com')->first();
        $userB = User::where('email', 'daotao@helpdesk.com')->first();

        $ticket = Ticket::create([
            'title' => 'Chỉ mình B thấy', 'description' => 'xxx',
            'status' => 'open',
            'user_id' => $userB->id,
            'category_id' => Category::first()->id,
            'priority_id' => Priority::first()->id,
        ]);

        $this->actingAs($userA)
            ->post(route('responses.store', $ticket), ['message' => 'hack'])
            ->assertForbidden();
        $this->assertDatabaseMissing('ticket_responses', ['ticket_id' => $ticket->id, 'user_id' => $userA->id]);
    }

    // S3: Tech B không cướp được ticket đã gán cho Tech khác
    public function test_tech_cannot_steal_assigned_ticket(): void
    {
        $tech = $this->user('Technician');
        // Tạo tech thứ hai
        $tech2 = User::create([
            'name' => 'Tech 2', 'email' => 'tech2@helpdesk.com',
            'password' => bcrypt('password12345'),
            'role_id' => $tech->role_id, 'department_id' => $tech->department_id,
        ]);

        $ticket = Ticket::create([
            'title' => 'X', 'description' => 'y', 'status' => 'in_progress',
            'user_id' => User::first()->id, 'assigned_to' => $tech->id,
            'category_id' => Category::first()->id, 'priority_id' => Priority::first()->id,
        ]);

        $this->actingAs($tech2)
            ->post(route('tickets.assign', $ticket))
            ->assertRedirect();
        $this->assertEquals($tech->id, $ticket->fresh()->assigned_to);
    }

    // S3: state machine chặn nhảy trạng thái sai
    public function test_status_transition_blocks_invalid_jump(): void
    {
        $tech = $this->user('Technician');
        $ticket = Ticket::create([
            'title' => 'X', 'description' => 'y', 'status' => 'open',
            'user_id' => User::first()->id,
            'category_id' => Category::first()->id, 'priority_id' => Priority::first()->id,
        ]);
        // open → closed là không hợp lệ
        $this->actingAs($tech)
            ->patch(route('tickets.updateStatus', $ticket), ['status' => 'closed'])
            ->assertSessionHas('error');
        $this->assertEquals('open', $ticket->fresh()->status);
    }

    // S7: Admin không đổi role chính mình
    public function test_admin_cannot_change_own_role(): void
    {
        $admin = $this->user('Admin');
        $userRoleId = \App\Models\Role::where('name', 'User')->value('id');
        $this->actingAs($admin)
            ->put(route('users.update', $admin), [
                'name' => $admin->name, 'email' => $admin->email,
                'role_id' => $userRoleId, 'department_id' => $admin->department_id,
            ])->assertSessionHas('error');
        $this->assertNotEquals($userRoleId, $admin->fresh()->role_id);
    }

    // B4: Chủ ticket sửa được khi còn open, không sửa được khi đã in_progress
    public function test_owner_can_edit_open_ticket_only(): void
    {
        $owner = User::where('email', 'user@helpdesk.com')->first();
        $ticket = Ticket::create([
            'title' => 'A', 'description' => 'B', 'status' => 'open',
            'user_id' => $owner->id,
            'category_id' => Category::first()->id, 'priority_id' => Priority::first()->id,
        ]);
        $this->actingAs($owner)
            ->put(route('tickets.update', $ticket), [
                'title' => 'Đã sửa', 'description' => 'x',
                'category_id' => Category::first()->id, 'priority_id' => Priority::first()->id,
            ])->assertRedirect();
        $this->assertEquals('Đã sửa', $ticket->fresh()->title);

        $ticket->update(['status' => 'in_progress']);
        $this->actingAs($owner)
            ->put(route('tickets.update', $ticket), [
                'title' => 'X', 'description' => 'y',
                'category_id' => Category::first()->id, 'priority_id' => Priority::first()->id,
            ])->assertForbidden();
    }

    // B6: notification tự sinh khi Tech tiếp nhận ticket
    public function test_notification_generated_on_assign(): void
    {
        $tech = $this->user('Technician');
        $owner = User::where('email', 'user@helpdesk.com')->first();
        $before = Notification::where('user_id', $owner->id)->count();

        $ticket = Ticket::create([
            'title' => 'X', 'description' => 'y', 'status' => 'open',
            'user_id' => $owner->id,
            'category_id' => Category::first()->id, 'priority_id' => Priority::first()->id,
        ]);
        $this->actingAs($tech)->post(route('tickets.assign', $ticket));

        $this->assertGreaterThan($before, Notification::where('user_id', $owner->id)->count());
    }

    // B5: user chỉ thấy notification của chính mình
    public function test_user_only_sees_own_notifications(): void
    {
        $user = User::where('email', 'user@helpdesk.com')->first();
        Notification::create([
            'user_id' => $user->id, 'title' => 'Riêng của tôi',
            'message' => 'x', 'type' => 'info', 'is_read' => false,
        ]);
        Notification::create([
            'user_id' => User::where('email', 'daotao@helpdesk.com')->first()->id,
            'title' => 'Không phải của tôi', 'message' => 'y', 'type' => 'info', 'is_read' => false,
        ]);

        $resp = $this->actingAs($user)->get(route('notifications.mine'));
        $resp->assertSee('Riêng của tôi');
        $resp->assertDontSee('Không phải của tôi');
    }

    // S11: Route /reports không còn crash
    public function test_reports_index_loads_for_admin(): void
    {
        $this->actingAs($this->user('Admin'))
            ->get(route('reports.index'))
            ->assertOk();
    }

    // B11: Báo cáo tài sản theo phòng chạy được
    public function test_assets_by_room_report_loads(): void
    {
        $this->actingAs($this->user('Admin'))
            ->get(route('reports.assets'))
            ->assertOk();
    }

    // B1: CRUD Asset đã có
    public function test_asset_create_route_works(): void
    {
        $this->actingAs($this->user('Admin'))
            ->get(route('assets.create'))
            ->assertOk();
    }

    // B2, B3: CRUD AssetCategory & MaintenanceLog
    public function test_asset_category_and_maintenance_log_routes_work(): void
    {
        $admin = $this->user('Admin');
        $this->actingAs($admin)->get(route('asset-categories.index'))->assertOk();
        $this->actingAs($admin)->get(route('maintenance-logs.index'))->assertOk();
    }

    // Nghiệm thu render tất cả view mới không throw
    public function test_all_new_views_render_without_errors(): void
    {
        $admin = $this->user('Admin');
        $user  = $this->user('User');

        // Ticket edit (chủ ticket, còn open)
        $ticket = Ticket::create([
            'title' => 'X', 'description' => 'y', 'status' => 'open',
            'user_id' => $user->id,
            'category_id' => Category::first()->id,
            'priority_id' => Priority::first()->id,
        ]);
        $this->actingAs($user)->get(route('tickets.edit', $ticket))->assertOk();

        // Notification cá nhân
        $this->actingAs($user)->get(route('notifications.mine'))->assertOk();

        // Assets CRUD views
        $this->actingAs($admin)->get(route('assets.create'))->assertOk();
        $asset = Asset::first();
        $this->actingAs($admin)->get(route('assets.edit', $asset))->assertOk();

        // AssetCategory
        $this->actingAs($admin)->get(route('asset-categories.create'))->assertOk();
        $this->actingAs($admin)->get(route('asset-categories.edit', AssetCategory::first()))->assertOk();

        // MaintenanceLog
        $this->actingAs($admin)->get(route('maintenance-logs.create'))->assertOk();
        // Có seed sẵn 3 log
        $log = \App\Models\MaintenanceLog::first();
        if ($log) $this->actingAs($admin)->get(route('maintenance-logs.edit', $log))->assertOk();

        // Reports
        $this->actingAs($admin)->get(route('reports.assets'))->assertOk();
    }

    // S5: Rate limit login sau 5 lần sai
    public function test_login_rate_limit_after_five_wrong_attempts(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', ['email' => 'admin@helpdesk.com', 'password' => 'wrong'])
                ->assertRedirect();
        }
        $r = $this->post('/login', ['email' => 'admin@helpdesk.com', 'password' => 'wrong']);
        $r->assertRedirect();
        $errors = session('errors');
        $this->assertNotNull($errors);
        $this->assertStringContainsString('quá nhiều lần', $errors->first('email'));
    }

    // S3: state machine cho phép in_progress -> resolved (kèm note)
    public function test_status_transition_in_progress_to_resolved_with_note(): void
    {
        $tech = $this->user('Technician');
        $ticket = Ticket::create([
            'title' => 'X', 'description' => 'y', 'status' => 'in_progress',
            'user_id' => User::first()->id, 'assigned_to' => $tech->id,
            'category_id' => Category::first()->id,
            'priority_id' => Priority::first()->id,
        ]);
        // Thiếu resolution_note → phải fail validation
        $this->actingAs($tech)
            ->patch(route('tickets.updateStatus', $ticket), ['status' => 'resolved'])
            ->assertSessionHasErrors('resolution_note');
        // Có resolution_note → OK
        $this->actingAs($tech)
            ->patch(route('tickets.updateStatus', $ticket), [
                'status' => 'resolved',
                'resolution_note' => 'Đã thay wifi mới',
            ])->assertRedirect();
        $f = $ticket->fresh();
        $this->assertEquals('resolved', $f->status);
        $this->assertNotNull($f->resolved_at);
        $this->assertEquals('Đã thay wifi mới', $f->resolution_note);
    }

    // B7: ticket_status_logs được ghi
    public function test_status_log_recorded_on_transition(): void
    {
        $tech = $this->user('Technician');
        $ticket = Ticket::create([
            'title' => 'X', 'description' => 'y', 'status' => 'open',
            'user_id' => User::first()->id,
            'category_id' => Category::first()->id,
            'priority_id' => Priority::first()->id,
        ]);
        $this->actingAs($tech)->post(route('tickets.assign', $ticket));
        $this->assertDatabaseHas('ticket_status_logs', [
            'ticket_id' => $ticket->id,
            'to_status' => 'in_progress',
        ]);
    }
}
