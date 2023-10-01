<?php

namespace  Dibiy\MgInstallable\Controllers;

use Illuminate\Routing\Controller;
use Dibiy\MgInstallable\Helpers\CheckLicenseManager;
use Dibiy\MgInstallable\Helpers\EnvironmentManager;
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
     * @var EnvironmentManager
     */
    protected $EnvironmentManager;

   

    /**
     * @param CheckLicenseManager $checkLicenseManager
     */
    public function __construct(
        CheckLicenseManager $checkLicenseManager,
        InstalledFileManager $fileManager,
        EnvironmentManager $environmentManager
        )
    {
        $this->checkLicenseManager = $checkLicenseManager;
        $this->fileManager = $fileManager;
        $this->EnvironmentManager = $environmentManager;


    }


    /**
     * Display the checkLicense page.
     *
     * @return \Illuminate\View\View
     */
    public function checkLicenseForm(Request $request)
    {
        $domainName=$this->EnvironmentManager->getDomainName($request);
        return view('vendor.mginstallable.check-licenseForm')->with(['error_message'=>null,'domainName'=>$domainName]);
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
            'app_domainName' => trans('installer_messages.checkLicense.form.domainName_required'),
            'app_key' => trans('installer_messages.checkLicense.form.key_required'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $redirect->route('mginstallable::checkLicenseForm')->withInput()->withErrors($validator->errors());
        }
        $inputs=$request->all();
        $response=$this->checkLicenseManager->checkLicenseKey($inputs);
        if(is_array($response)){
            $object=(object) $response;
            if(array_key_exists("data",$response) && $object && $object->data){
                $this->fileManager->createCheckLicenseFile($object->data);
                return $redirect->route('mginstallable::environment');
            }
        }else{
            $error_message=$response;
            return $redirect->route('mginstallable::checkLicenseForm')->withInput()->withErrors([
                'error_message'=>$error_message
            ]);
        }
    }
}