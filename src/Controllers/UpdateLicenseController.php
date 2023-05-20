<?php

namespace Dibiy\MgInstallable\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Validator;
use Dibiy\MgInstallable\Helpers\CheckLicenseManager;
use Dibiy\MgInstallable\Helpers\InstalledFileManager;

class UpdateLicenseController extends Controller
{
    use \Dibiy\MgInstallable\Helpers\MigrationsHelper;


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
     * Display the updater welcome page.
     *
     * @return \Illuminate\View\View
     */
    public function formUpdateLicense()
    {
        return view('vendor.mginstallable.update_license.update-licenseForm');
    }


        /**
     * Processes the newly check license key .
     *
     * @param Request $request
     * @param Redirector $redirect
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCheckLicense(Request $request, Redirector $redirect)
    {

        $rules = config('Installable.checkLicense.form.rules');
        $messages = [
            'app_name' => trans('installer_messages.checkLicense.form.name_required'),
            'app_key' => trans('installer_messages.checkLicense.form.key_required'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $redirect->route('LicenseUpdater::form_update_license')->withInput()->withErrors($validator->errors());
        }
        $inputs=$request->all();
        $response=$this->checkLicenseManager->checkLicenseKey($inputs);
        $object=(object) $response;
        if(array_key_exists("data",$response) && $object && $object->data && $object->data->active=="1"){
            $this->fileManager->createCheckLicenseFile($object->data);
            return $redirect->route('LicenseUpdater::final');
        }
        $error_message=$object->message;
        return $redirect->route('LicenseUpdater::form_update_license')->withInput()->withErrors([
            'error_message'=>$error_message
        ]);

    }


    /**
     * Update installed file and display finished view.
     *
     * @param InstalledFileManager $fileManager
     * @return \Illuminate\View\View
     */
    public function finish()
    {
        return view('vendor.mginstallable.update_license.finished');
    }

}
