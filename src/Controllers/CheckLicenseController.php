<?php

namespace  Dibiy\MgInstallable\Controllers;

use Illuminate\Routing\Controller;
use Dibiy\MgInstallable\Helpers\CheckLicenseManager;
use Dibiy\MgInstallable\Helpers\InstalledFileManager;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Validator;

class CheckLicenseController extends Controller
{


    /**
    * @var CheckLicenseManager
    */
    protected $checkLicenseManager;

    /**
    * @var InstalledFileManager
    */
    protected $fileManager;

   

    /**
     * @param CheckLicenseManager $checkLicenseManager
     */
    public function __construct(
        CheckLicenseManager $checkLicenseManager,
        InstalledFileManager $fileManager)
    {
        $this->checkLicenseManager = $checkLicenseManager;
        $this->fileManager = $fileManager;

    }


    /**
     * Display the checkLicense page.
     *
     * @return \Illuminate\View\View
     */
    public function checkLicenseForm()
    {
        return view('vendor.mginstallable.check-licenseForm')->with(['error_message'=>null]);
    }

    /**
     * Processes the newly check license key .
     *
     * @param Request $request
     * @param Redirector $redirect
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkLicencseKey(Request $request, Redirector $redirect)
    {

        $rules = config('Installable.checkLicense.form.rules');
        $messages = [
            'app_name' => trans('installer_messages.checkLicense.form.name_required'),
            'app_key' => trans('installer_messages.checkLicense.form.key_required'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $redirect->route('mginstallable::checkLicenseForm')->withInput()->withErrors($validator->errors());
        }
        $inputs=$request->all();
        $response=$this->checkLicenseManager->checkLicenseKey($inputs);
        $object=(object) $response;
        if(array_key_exists("data",$response) && $object && $object->data){
            $this->fileManager->createCheckLicenseFile($object->data);
            return $redirect->route('mginstallable::environment');
        }
        $error_message=$object->message;
        return $redirect->route('mginstallable::checkLicenseForm')->withInput()->withErrors([
            'error_message'=>$error_message
        ]);

    }
}