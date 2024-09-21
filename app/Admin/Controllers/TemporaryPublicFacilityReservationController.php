<?php

namespace App\Admin\Controllers;

use App\Models\TemporaryPublicFacilityReservation;
use App\Models\PublicFacility;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TemporaryPublicFacilityReservationController extends AdminController
{
    protected $title = '公共施設仮予約';

    protected function grid()
    {
        $grid = new Grid(new TemporaryPublicFacilityReservation());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('reservation_name', __('予約者名'))->sortable();
        $grid->column('reservation_date', __('予約日'))->sortable();
        $grid->column('approval_flag', __('承認フラグ'))->switch([
            0 => '申請中',
            1 => '承認済',
            2 => '却下'
        ]);

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new TemporaryPublicFacilityReservation());

        $form->select('facility_id', '公共施設')->options(PublicFacility::all()->pluck('name', 'id'))->required();
        $form->text('reservation_name', __('予約者名'))->required();
        $form->text('reservation_phone', __('予約者電話番号'))->required();
        $form->text('reservation_email', __('予約者メールアドレス'))->required();
        $form->text('reservation_postal_code', __('予約者郵便番号'))->required();
        $form->text('reservation_address', __('予約者住所'))->required();
        $form->date('reservation_date', __('予約日'))->required();
        $form->number('people', __('人数'))->required();
        $form->number('reservation_time', __('予約時間'))->required();
        $form->switch('approval_flag', __('承認フラグ'))->options([
            0 => '申請中',
            1 => '承認済',
            2 => '却下'
        ]);

        return $form;
    }

    protected function detail($id)
    {
        $show = new Show(TemporaryPublicFacilityReservation::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('facility_id', __('公共施設'));
        $show->field('reservation_name', __('予約者名'));
        $show->field('reservation_date', __('予約日'));
        $show->field('people', __('人数'));
        $show->field('reservation_time', __('予約時間'));
        $show->field('approval_flag', __('承認フラグ'));

        return $show;
    }
}
