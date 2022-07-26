<?php


namespace App\Libraries;


use App\Constants\GeneralConstants;
use App\Diet;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Facades\App\Libraries\ProfileHelper;
use Facades\App\Libraries\InvoiceHelper;
use Facades\App\Libraries\CacheHelper;

class DietHelper
{

    public function getAllDiets($just_active = true)
    {
        $stm = Diet::orderBy('sort', 'DESC');
        if ($just_active) {
            $stm = $stm->where('status', 'active');
        }
        return $stm->get();
    }

    public function getDietBySlug($slug, $force_to_refresh_cache = false, $abort = true)
    {
        $diet = Diet::where('slug', $slug)->first();
        if (empty($diet) && $abort) {
            abort(404);
        }
        return $diet;
    }

    public function canGetDiet($user, $diet)
    {
        if ($diet->status != 'active') {
            return false;
        }
        $permission_name = GeneralConstants::DIET_PERMISSION_NAME_PREFIX . $diet->id;
        return (!$diet->need_permission && $user->can('get_ordinary_diets')) ||
            ($diet->need_permission && $user->can($permission_name));
    }
}
