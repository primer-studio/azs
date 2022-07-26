<?php


namespace App\Constants;


class GeneralConstants
{
    # =========================  transaction - start ========================= #
    const TRANSACTION_STARTED = 'started';
    const TRANSACTION_WEB_GATE = 'web_gate';
    const TRANSACTION_CALLBACK = 'callback';
    const TRANSACTION_VERIFIED = 'verified';
    const TRANSACTION_AMOUNT_MISMATCH_ON_VERIFY = 'amount_mismatch_on_verify';
    const TRANSACTION_VERIFY_DATA_NOT_CORRECT = 'verify_data_not_correct';
    const TRANSACTION_CALLBACK_DATA_NOT_CORRECT = 'callback_data_not_correct';
    # =========================  transaction -  end  ========================= #

    # =========================  order - start ========================= #
    const ORDER_STATUS_CREATED = 'created';
    const ORDER_STATUS_COMPLETED = 'completed';
    # =========================  order -  end  ========================= #

    # =========================  payment - start ========================= #
    const PAYMENT_WAY_IPG = 'ipg';
    const PAYMENT_WAY_OFFLINE = 'offline';
    const PAYMENT_WAY_MANUAL_BY_ADMIN = 'manual_by_admin';
    # =========================  payment -  end  ========================= #

    # =========================  offline payment types - start ========================= #
    const  OFFLINE_PAYMENT_TYPE_CARD_TO_CARD = 'card_to_card';
    const  OFFLINE_PAYMENT_TYPE_DEPOSIT_BY_BANK_RECEIPT = 'deposit_by_bank_receipt';
    # =========================  offline payment types -  end  ========================= #

    # =========================  affiliation_partner - start ========================= #
    const AFFILIATION_PARTNER_ID_SESSION_KEY = 'affiliation_partner_id';
    # =========================  affiliation_partner -  end  ========================= #

    # =========================  affiliation invoice - start ========================= #
    const AFFILIATION_INVOICE_STATUS_CREATED = 'created';
    const AFFILIATION_INVOICE_STATUS_CHECKOUT = 'checkout';
    # =========================  affiliation invoice -  end  ========================= #

    # =========================  last_query_string_data (user) - start ========================= #
    const LAST_QUERY_STRING_DATA_SESSION_KEY = 'last_query_string_data';
    # =========================  last_query_string_data (user) -  end  ========================= #

    # =========================  roles - start ========================= #
    const DEFAULT_USER_ROLE = 'کاربر عادی';
    # =========================  roles -  end  ========================= #

    # =========================  permissions - start ========================= #
    const DIET_PERMISSION_NAME_PREFIX = 'get_diet_';
    # =========================  permissions -  end  ========================= #

    # =========================  verification_code_generated - start ========================= #
    const VERIFICATION_CODE_GENERATED_FOR_MOBILE_NUMBER_SESSION_KEY = 'verification_code_generated_for_mobile_number';
    # =========================  verification_code_generated -  end  ========================= #

}
