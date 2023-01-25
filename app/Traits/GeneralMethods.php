<?php
/*****************************************************/
# Purpose : for global use
/*****************************************************/

namespace App\Traits;

trait GeneralMethods
{
    /*
        * Function Name : assignBreadcrumb
        * Purpose       : Assign breadcrumb
        * Author        : 
        * Created Date  : 
        * Modified date :          
        * Input Params  : Void
        * Return Value  : Mixed
    */
    public function assignBreadcrumb() {
        $this->breadcrumb = $breadcrumb = [
            'LISTPAGE' =>
            [
                ['label' => $this->management . ' '.__('custom_admin.label_list'), 'url' => '']
            ],
            'CREATEPAGE' =>
            [
                ['label' => $this->management . ' '.__('custom_admin.label_list'), 'url' => $this->listUrl ? \URL::route($this->routePrefix.'.'.$this->listUrl) : ''],
                ['label' => __('custom_admin.label_create'), 'url' => '']
            ],
            'EDITPAGE' =>
            [
                ['label' => $this->management . ' '.__('custom_admin.label_list'), 'url' => $this->listUrl ? \URL::route($this->routePrefix.'.'.$this->listUrl) : ''],
                ['label' => __('custom_admin.label_edit'), 'url' => '']
            ],
            'VIEWPAGE' =>
            [
                ['label' => $this->management . ' '.__('custom_admin.label_list'), 'url' => $this->listUrl ? \URL::route($this->routePrefix.'.'.$this->listUrl) : ''],
                ['label' => $this->management . ' '.__('custom_admin.label_view'), 'url' => '']
            ],
            'SORTPAGE' =>
            [
                ['label' => $this->management . ' '.__('custom_admin.label_list'), 'url' => $this->listUrl ? \URL::route($this->routePrefix.'.'.$this->listUrl) : ''],
                ['label' => __('custom_admin.label_sort'), 'url' => '']
            ],
            'DETAILPAGE' =>
            [
                ['label' => $this->management . ' '.__('custom_admin.label_list'), 'url' => $this->listUrl ? \URL::route($this->routePrefix.'.'.$this->listUrl) : ''],
                ['label' => $this->management . ' '.__('custom_admin.label_details'), 'url' => '']
            ],
            'GALLERYPAGE' =>
            [
                ['label' => $this->management . ' '.__('custom_admin.label_list'), 'url' => $this->listUrl ? \URL::route($this->routePrefix.'.'.$this->listUrl) : ''],
                ['label' => __('custom_admin.label_gallery'), 'url' => '']
            ],
            'ALLBOOKINGSPAGE' =>
            [
                ['label' => __('custom_admin.label_all_bookings'), 'url' => '']
            ],
            'RESETPASSWORDPAGE' =>
            [
                ['label' => $this->management . ' '.__('custom_admin.label_list'), 'url' => $this->listUrl ? \URL::route($this->routePrefix.'.'.$this->listUrl) : ''],
                ['label' => $this->management . ' '.__('custom_admin.label_reset_password'), 'url' => '']
            ],
        ];
    }

    /*
        * Function Name : assignShareVariables
        * Purpose       : Assign common variable to use in views for admin
        * Input Params  : Void
        * Return Value  : Mixed
    */
    public function assignShareVariables() {
        \View::share([
            'management'    => $this->management,
            'modelName'     => $this->modelName,
            'breadcrumb'    => $this->breadcrumb,
            'routePrefix'   => $this->routePrefix,
            'pageRoute'     => $this->pageRoute,
            'urlPrefix'     => $this->urlPrefix ?? '',
            'listUrl'       => $this->listUrl ?? '',
            'listRequestUrl'=> $this->listRequestUrl ?? '',
            'createUrl'     => $this->createUrl ?? '',
            'editUrl'       => $this->editUrl ?? '',
            'viewUrl'       => $this->viewUrl ?? '',
            'statusUrl'     => $this->statusUrl ?? '',
            'deleteUrl'     => $this->deleteUrl ?? '',
            'sortUrl'       => $this->sortUrl ?? '',
            'detailsUrl'    => $this->detailsUrl ?? '',
            'galleryListUrl'=> $this->galleryListUrl ?? '',
            'controllerName'=> $this->controllerName,
            'as'            => $this->as ?? '',
        ]);
    }

    /*
        * Function Name : shareVariables
        * Purpose       : Assign common variable to use in views for frontend
        * Input Params  : Void
        * Return Value  : Mixed
    */
    public function shareVariables() {
        \View::share([
            'bannerStorage'         => 'banner',
            'cmsStorage'            => 'cms',
            'accountStorage'        => 'account',
            'serviceStorage'        => 'service',
            'language'              => \App::getLocale(),
            'settingData'           => getSiteSettings(),
            'serviceSlug'           => '',
        ]);
    }

}
