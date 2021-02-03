<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        return view('admin.pages.menu.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['parent_id'] = null;
        $data['sort'] = 200;
        Menu::create($data);
        $menu_list = $this->getMenuTree($request->category);
        return response()->json(['success' => 'Thêm mới menu thành công', 'menus' => $menu_list]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $list_menu = Menu::all();
        $menu = Menu::find($id);
        if (!$menu) {
            abort(404);
        }
        return view('admin.pages.admin_manage.menu_edit', ['list_menu' => $list_menu, 'menu' => $menu]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $menu = Menu::findOrFail($request->id);
        $data = $request->all();
        $menu->update($data);

        $menu_list = $this->getMenuTree($request->category);
        return response()->json(['success' => 'Sửa thành công', 'menus' => $menu_list]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Menu::findOrFail($request->id)->delete();
        $menu_list = $this->getMenuTree($request->category);
        return response()->json(['success' => 'Xóa thành công', 'menus' => $menu_list]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveTree(Request $request)
    {
        $data = $request->jsonData;
        // dd($data);
        $result = [];
        function getMenuAndParent($result = [], $array, $parent_id)
        {
            foreach ($array as $key => $item) {
                //return $item['id'];
                array_push($result, ['id' => $item['id'], 'parent_id' => $parent_id, 'sort' => $key + 1]);
                if (array_key_exists('children', $item)) {
                    array_push($result, ...getMenuAndParent([], $item['children'], $item['id']));
                }
            }
            return $result;
        }

        $result = getMenuAndParent([], $data, null);

        foreach ($result as $item) {
            $menu = Menu::find($item['id']);
            $menu->parent_id = $item['parent_id'];
            $menu->sort = $item['sort'];
            $menu->save();
        }

        return $result;
    }

    private function getMenuTree($category)
    {
        $menu_list = Menu::where('category', $category)->where('parent_id', null)->orderBy('sort')->get();
        return $menu_list->toJson(JSON_PRETTY_PRINT);
    }

}