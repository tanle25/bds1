<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use DataTables;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('admin.pages.contacts.index');
    }

    function list() {
        $list_request = Contact::query();

        return DataTables::eloquent($list_request)
            ->addIndexColumn()
            ->editColumn('status', function ($contact) {
                switch ($contact->status) {
                    case 1:
                        return '<span class="badge badge-success">Đã tư vấn</span>';
                    default:
                        return '<span class="badge badge-danger">chưa tư vấn</span>';
                }
            })
            ->addColumn('action', function ($contact) {
                return '
                <a
                data-toggle-for="tooltip"
                title="Xem chi tiết"
                href="' . route('admin.contacts.edit', $contact->id ?? 0) . '"
                class="btn text-success"
                ><i class="fas fa-eye"></i></a>

                <a
                data-toggle-for="tooltip"
                title="Xóa"
                href="' . route('admin.contacts.destroy', $contact->id ?? 0) . '"
                class="btn text-danger class-request-delete">
                <i class="fas fa-trash"></i></a>
                ';
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function store(ContactRequest $request)
    {
        $data = $request->all();
        $input = [
            'fullname' => $request->contact_name,
            'email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'contact_message' => $request->contact_message,
        ];
        if (!$request->contact_email && !$request->contact_phone) {
            return redirect()->back()->with(['error' => 'Bạn vui lòng nhập thông tin để chúng tôi có thể liên hệ!']);
        }
        $new_contact = Contact::create($input);
        return redirect()->back()->with('success', 'Cảm ơn bạn đã phản hồi chúng tôi sẽ liên hệ với bạn ngay!');
    }

    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.pages.contacts.edit', compact('contact'));
    }

    public function update($id, Request $request)
    {
        $data = $request->all();
        $contact = Contact::findOrFail($id);

        $contact->update($data);

        return redirect()->back()->with('success', 'Sửa thông tin thành công!');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id)->delete();
        return ['msg' => 'Xóa thành công!'];
    }

    public function showFrontend()
    {
        return view('customer.pages.contacts.index');
    }
}