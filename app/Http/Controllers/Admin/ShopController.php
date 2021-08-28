<?php

namespace App\Http\Controllers\Admin;

use App\Models\Webserver\ShopCategory;
use App\Models\Webserver\ShopItem;
use App\Models\Webserver\ShopSubCategory;

use Illuminate\Http\Request;

class ShopController extends Controller
{
  /**
   * GET /admin/shop/all
   */
  public function allItems()
  {
    return view('admin.shop.items', [
        'results' => ShopItem::withCategory()->paginate(20),
        'title'   => 'All items in the shop'
    ]);
  }

  /**
   * GET/POST /admin/shop-category
   */
  public function shopCategory(Request $request)
  {
      // When try to add Category
      if($request->isMethod('post')) {
          ShopCategory::create([
              'category_name' => $request->input('category_name')
          ]);
      }

      $categories = ShopCategory::get();

      return view('admin.shop.category', [
          'categories' => $categories
      ]);
  }

  /**
   * GET/POST /admin/shop-subcategory
   */
  public function shopSubCategory(Request $request)
  {
      // When try to add SubCategory
      if($request->isMethod('post')) {
          ShopSubCategory::create([
              'id_category' => $request->input('category_id'),
              'name' => $request->input('sub_category_name')
          ]);
      }

      $categories             = ShopCategory::get();
      $categoriesSelectInput  = [];
      $subCategories          = ShopSubCategory::get();

      // Create beautiful array for select Input
      foreach($categories as $category){
          $categoriesSelectInput[$category->category_name] = [
            $category->id => $category->category_name
          ];
      }

      return view('admin.shop.subcategory', [
          'categories'    => $categoriesSelectInput,
          'subCategories' => $subCategories
      ]);
  }

  /**
   * GET /admin/shop-add
   */
  public function shopAdd(Request $request)
  {

      // Success message
      $success = null;

      // When try to add item
      if($request->isMethod('post')) {
          $itemAdded = ShopItem::create([
              'id_sub_category' => $request->input('id_sub_category'),
              'id_item'         => $request->input('id_item'),
              'quality_item'    => $request->input('quality_item'),
              'name'            => $request->input('name'),
              'price'           => $request->input('price'),
              'quantity'        => $request->input('quantity'),
              'level'           => $request->input('level'),
              'preview'         => (int) $request->input('preview'),
              'purchased'       => 0
          ]);

          if($itemAdded !== null){
              $success = $request->input('name')." was added successfully";
          }
      }

      // List all Sub-Categories group by Category
      $categories = ShopCategory::all()->reduce(function($acc, $cat) {
          $subCategories = ShopSubCategory::where('id_category', $cat->id)->get();

          $acc[$cat->category_name] = $subCategories->reduce(function($ac, $sub) {
              $ac[$sub->id] = $sub->name;

              return $ac;
          }, []);

          return $acc;
      }, []);

      return view('admin.shop.add', [
          'categories' => $categories,
          'success'    => $success
      ]);
  }

  /**
   * GET /admin/shop-edit/{id}
   */
  public function shopEdit(Request $request, $id)
  {
      // Success message
      $success = null;

      // When try to edit item
      if($request->isMethod('post')){
          $itemSaved = ShopItem::where('id_item', '=', $id)->update([
              'id_sub_category' => $request->input('id_sub_category'),
              'id_item'         => $request->input('id_item'),
              'name'            => $request->input('name'),
              'price'           => $request->input('price'),
              'quantity'        => $request->input('quantity'),
              'level'           => $request->input('level'),
              'preview'         => (int) $request->input('preview')
          ]);

          if($itemSaved !== null){
              $success = $request->input('name')." was successfully changed";
          }

      }

      $item  = ShopItem::where('id_item', '=', $id)->first();

      // List all Sub-Categories group by Category
      $categories = ShopCategory::all()->reduce(function($acc, $cat) {
          $subCategories = ShopSubCategory::where('id_category', $cat->id)->get();

          $acc[$cat->category_name] = $subCategories->reduce(function($ac, $sub) {
              $ac[$sub->id] = $sub->name;

              return $ac;
          }, []);

          return $acc;
      }, []);

      return view('admin.shop.edit', [
          'item'          => $item,
          'categories'    => $categories,
          'success'       => $success
      ]);
  }

  /**
   * GET /admin/shop/subcategory/{id}
   */
  public function ItemsInSubCategory($id)
  {
      $subCategory = ShopSubCategory::find($id);
      $items = ShopItem::where('id_sub_category', '=', $id)->paginate(20);

      return view('admin.shop.items', [
          'results' => $items,
          'title'   => $subCategory->name
      ]);
  }

  /**
   * GET /admin/shop/category/{id}
   */
  public function ItemsInCategory($id)
  {
    $category         = ShopCategory::find($id);
    $subCategories    = ShopSubCategory::where('id_category', $category->id)->get();
    $subCategoriesId  = $subCategories->reduce(function($acc, $item) {
      $acc[] = $item->id;
      return $acc;
    }, []);

    return view('admin.shop.items', [
        'results' => ShopItem::whereIn('id_sub_category', $subCategoriesId)->paginate(20),
        'title'   => $category->category_name
    ]);
  }

  /**
   *
   * Get /admin/shop/delete/{id}
   *
   * @param [integer] $id Item's ID
   */
  public function shopDelete($id)
  {
      ShopItem::where('id_item', $id)->delete();

      return back()->with('success', 'Object was successfully deleted');
  }

}
