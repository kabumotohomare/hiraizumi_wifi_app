<?php
namespace App\Admin\Controllers;

use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CategoryController extends AdminController
{
    protected $title = 'カテゴリ情報';

    protected function grid()
    {
        $grid = new Grid(new Category());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('category_name', __('Category Name'))->sortable()->filter('like');
        $grid->column('reservation_flag', __('Reservation Flag'))->switch()->filter([
            0 => '予約不可',
            1 => '予約可'
        ]);
        $grid->column('display_flag', __('Display Flag'))->switch()->filter([
            0 => '非表示',
            1 => '表示中'
        ]);
        $grid->column('color_code', __('Hex Color Code'))->editable();  // 新しく追加されたカラーフィールド
        $grid->column('sort_order', __('Sort Order'))->sortable()->editable();  // 新しく追加された並び順フィールド

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new Category());

        $form->text('category_name', __('Category Name'))->required();
        $form->switch('reservation_flag', __('Reservation Flag'));
        $form->switch('display_flag', __('Display Flag'));
        $form->color('color_code', __('Hex Color Code'))->default('#000000');  // カラーフィールドの設定
        $form->number('sort_order', __('Sort Order'))->min(0)->default(0);  // 並び順フィールドの設定

        return $form;
    }
}
