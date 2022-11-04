<?php

namespace App\Http\Controllers;

use App\Libraries\ProfileHelper;
use App\Libraries\UserHelper;
use App\ProfileAssets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ProfileAssetsController extends Controller
{
    protected function get_mime_type($filename) {
        $idx = explode( '.', $filename );
        $count_explode = count($idx);
        $idx = strtolower($idx[$count_explode-1]);

        $mimet = array(
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',
            'mp4' => 'video/mp4',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',
            'docx' => 'application/msword',
            'xlsx' => 'application/vnd.ms-excel',
            'pptx' => 'application/vnd.ms-powerpoint',


            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        if (isset( $mimet[$idx] )) {
            return $mimet[$idx];
        } else {
            return 'application/octet-stream';
        }
    }

    public function list(Request $request, $action = false, $id = 0)
    {
        if ($request->isMethod('GET')) {

            $profile = new ProfileHelper;
            $assets = ProfileAssets::where('profile_id', $profile->getCurrentProfile()->id)->latest()->get();
            $orders = \Facades\App\Libraries\ProfileHelper::getCurrentProfile()->orders()->with('invoiceItem')->latest()->get();
            return view('dashboard.main')->nest('content', 'dashboard.assets.list', compact(['profile', 'assets', 'orders']));

        } elseif ($request->isMethod('POST')) {
            $profile = new ProfileHelper;
            if (!$action || !$id) {
                return abort(403, 'access forbidden.');
            }
            if ($action == 'update') {
                $request->validate([
                    'order' => 'required',
                    'asset_visibility' => 'required',
                    'asset' => 'required',
                ]);
                $asset = ProfileAssets::findOrFail($id);
                if ($asset->profile_id == $profile->getCurrentProfile()->id) {
                    $asset->update([
                        'order_id' => $request['order'],
                        'asset_visibility' => $request['asset_visibility'],
                    ]);
                    return redirect()->back()->with('message', 'با موفقیت ذخیره شد.');
                } else {
                    return abort(403, 'access forbidden.');
                }
            } elseif ($action == 'delete') {
                $request->validate([
                    'asset' => 'required',
                ]);
                $asset = ProfileAssets::findOrFail($id);
                $info = $asset->getInfo(true);
                $info['deleted'] = true;
                $asset->update([
                    'asset_info' => json_encode($info),
                ]);

                return redirect()->back();
            } else {
                return abort(403, 'action not allowed.');
            }
        } else {
            return abort(403, 'Method not allowed');
        }
    }

    public function upload(Request $request)
    {
        $request->validate([
            'asset' => 'required|file|max:10240|mimes:jpg,jpeg,png,gif,mp4,mkv'
        ]);
        $profile = new ProfileHelper;
        $user_id = Auth::id();
        $profile_id = $profile->getCurrentProfile()->id;
        $orders = \Facades\App\Libraries\ProfileHelper::getCurrentProfile()->orders()->with('invoiceItem')->latest()->get();
        $order_id = $orders[0]->id;

        $image = $request->file('asset');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Storage::disk('local')->put("private/profile_assets/{$profile_id}/$name_gen", file_get_contents($image));
        $asset = new ProfileAssets();
        $asset->user_id = $user_id;
        $asset->profile_id = $profile_id;
        $asset->order_id = $order_id;
        $asset->asset_type = $this->get_mime_type($name_gen);
        $asset->asset_visibility = 'private';
        $asset->asset_info = json_encode([
            'url' => $name_gen,
            'container' => $this->get_mime_type($name_gen)
        ]);
        $asset->save();
        return response()->json([
            'status' => 200,
            'message' => 'uploaded successfully.'
        ]);
    }

    public function secretURL(Request $request, $id)
    {
        $profile = new ProfileHelper;
        $user_id = Auth::id();
        $profile_id = $profile->getCurrentProfile()->id;

        $asset = ProfileAssets::findOrFail(Crypt::decryptString($id));
        if ($asset->user_id == $user_id && $asset->profile_id == $profile_id) {
            $info = json_decode($asset->asset_info);
            $mime = $this->get_mime_type($info->url);
            $file = Storage::get("private/profile_assets/{$asset->profile_id}/{$info->url}");
            $response = Response::make($file, 200);
            $response->header('Content-Type', $mime);
            return $response;
        } else {
            return abort('404', 'Not found');
        }
    }
}
