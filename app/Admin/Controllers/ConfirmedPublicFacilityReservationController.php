<?php

namespace App\Admin\Controllers;

use App\Models\ConfirmedPublicFacilityReservation;
use App\Models\PublicFacility;
use App\Models\TemporaryPublicFacilityReservation;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ConfirmedPublicFacilityReservationController extends AdminController
{
    protected $title = '公共施設予約確定';

    protected function grid()
    {
        $grid = new Grid(new ConfirmedPublicFacilityReservation());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('confirmed_reservation_date', __('予約確定日'))->sortable()->filter('date');
        $grid->column('cancel_flag', __('キャンセルフラグ'))->switch([
            0 => '未キャンセル',
            1 => 'キャンセル'
        ]);

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new ConfirmedPublicFacilityReservation());

        $form->select('facility_id', '公共施設')->options(PublicFacility::all()->pluck('name', 'id'))->required();
        // Change the alias for the temporary reservation
        $form->select('temp_reservation_id', '仮予約')->options(TemporaryPublicFacilityReservation::all()->pluck('reservation_name', 'id'))->required();
        $form->date('confirmed_reservation_date', __('予約確定日'))->required();
        $form->number('confirmed_reservation_time', __('予約確定時間'))->required();
        $form->number('people', __('人数'))->required();
        $form->switch('cancel_flag', __('キャンセルフラグ'))->options([
            0 => '未キャンセル',
            1 => 'キャンセル'
        ]);

        return $form;
    }

    protected function detail($id)
    {
        $show = new Show(ConfirmedPublicFacilityReservation::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('facility_id', __('公共施設'));
        $show->field('temp_reservation_id', __('仮予約'));
        $show->field('confirmed_reservation_date', __('予約確定日'));
        $show->field('people', __('人数'));
        $show->field('cancel_flag', __('キャンセルフラグ'));

        return $show;
    }
}
