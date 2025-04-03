<?php

namespace App\Http\Controllers;

use App\Services\admin\DestroyService;
use App\Services\Admin\RecycleBinService;
use Illuminate\Http\Request;

class AdminDelete extends Controller
{
    protected $destroyService;
    protected $recycleBinService;
    public function __construct(DestroyService $destroyService, RecycleBinService $recycleBinService)
    {
        $this->destroyService = $destroyService;
        $this->recycleBinService = $recycleBinService;
    }
    public function recycle_bin()
    {
        $data = $this->recycleBinService->getTrashedItems();
        return view('admin.index.recycle_bin', compact('data'));
    }
    public function del_ticket($id_ticket)
    {
        return $this->destroyService->delete_ticket($id_ticket);
    }
    public function del_event($id_event)
    {
        return $this->destroyService->delete_event($id_event);
    }
    public function del_user($id_user)
    {
        return $this->destroyService->delete_user($id_user);
    }

    public function restoreEvent($id_event)
    {
        $this->recycleBinService->restoreEvent($id_event);
        return redirect()->route('admin.recycle-bin')->with('success', 'Khôi phục sự kiện thành công!');
    }

    public function forceDeleteEvent($id_event)
    {
        $this->recycleBinService->forceDeleteEvent($id_event);
        return redirect()->route('admin.recycle-bin')->with('success', 'Xóa vĩnh viễn sự kiện thành công!');
    }

    public function restoreTicket($id_ticket)
    {
        $this->recycleBinService->restoreTicket($id_ticket);
        return redirect()->route('admin.recycle-bin')->with('success', 'Khôi phục vé thành công!');
    }

    public function forceDeleteTicket($id_ticket)
    {
        $this->recycleBinService->forceDeleteTicket($id_ticket);
        return redirect()->route('admin.recycle-bin')->with('success', 'Xóa vĩnh viễn vé thành công!');
    }

    public function restoreUser($id)
    {
        $this->recycleBinService->restoreUser($id);
        return redirect()->route('admin.recycle-bin')->with('success', 'Khôi phục người dùng thành công!');
    }

    public function forceDeleteUser($id)
    {
        $this->recycleBinService->forceDeleteUser($id);
        return redirect()->route('admin.recycle-bin')->with('success', 'Xóa vĩnh viễn người dùng thành công!');
    }
}
