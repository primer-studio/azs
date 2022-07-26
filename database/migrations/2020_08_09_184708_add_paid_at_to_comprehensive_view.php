<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPaidAtToComprehensiveView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP VIEW comprehensive_report");
        DB::statement("
            CREATE VIEW comprehensive_report AS
            SELECT
            U.id as user_id,
            U.mobile_number,
            U.mobile_number_verified_at,
            U.is_temp,
            U.created_at as user_created_at,
            U.updated_at as user_updated_at,
            P.id as profile_id,
            P.name,
            P.gender,
            P.city,
            P.is_dissatisfied,
            P.in_progress,
            P.in_progress_by,
            P.created_at as profile_created_at,
            P.updated_at as profile_updated_at,
            I.id as invoice_id,
            I.status as invoice_status,
            I.invoice_number,
            I.total_amount,
            I.total_amount_without_vat,
            I.service_delivered,
            I.payment_way,
            I.refid,
            I.paid_at as paid_at,
            I.created_at as invoice_created_at,
            I.updated_at as invoice_updated_at,
            II.id as invoice_item_id,
            II.diet_id,
            II.diet_period,
            II.quantity,
            II.pending_questions,
            II.created_at as invoice_item_created_at,
            II.updated_at as invoice_item_updated_at,
            O.id as order_id,
            O.status as order_status,
            O.seen as order_seen,
            O.start_date as order_start_date,
            O.end_date as order_end_date,
            O.duration_in_day as order_duration_in_day,
            O.created_at as order_created_at,
            O.updated_at as order_updated_at
            FROM users as U
            LEFT JOIN profiles P ON U.id = P.user_id
            LEFT JOIN invoices I ON P.id = I.profile_id
            LEFT JOIN invoice_items II ON I.id = II.invoice_id
            LEFT JOIN orders O ON II.id = O.invoice_item_id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW comprehensive_report");
        DB::statement("
            CREATE VIEW comprehensive_report AS
            SELECT
            U.id as user_id,
            U.mobile_number,
            U.mobile_number_verified_at,
            U.is_temp,
            U.created_at as user_created_at,
            U.updated_at as user_updated_at,
            P.id as profile_id,
            P.name,
            P.gender,
            P.city,
            P.is_dissatisfied,
            P.in_progress,
            P.in_progress_by,
            P.created_at as profile_created_at,
            P.updated_at as profile_updated_at,
            I.id as invoice_id,
            I.status as invoice_status,
            I.invoice_number,
            I.total_amount,
            I.total_amount_without_vat,
            I.service_delivered,
            I.payment_way,
            I.refid,
            I.created_at as invoice_created_at,
            I.updated_at as invoice_updated_at,
            II.id as invoice_item_id,
            II.diet_id,
            II.diet_period,
            II.quantity,
            II.pending_questions,
            II.created_at as invoice_item_created_at,
            II.updated_at as invoice_item_updated_at,
            O.id as order_id,
            O.status as order_status,
            O.seen as order_seen,
            O.start_date as order_start_date,
            O.end_date as order_end_date,
            O.duration_in_day as order_duration_in_day,
            O.created_at as order_created_at,
            O.updated_at as order_updated_at
            FROM users as U
            LEFT JOIN profiles P ON U.id = P.user_id
            LEFT JOIN invoices I ON P.id = I.profile_id
            LEFT JOIN invoice_items II ON I.id = II.invoice_id
            LEFT JOIN orders O ON II.id = O.invoice_item_id
        ");
    }
}
