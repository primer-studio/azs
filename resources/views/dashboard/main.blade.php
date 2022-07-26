@extends('dashboard.layouts.app')

@section('body')
<div class="innerContainer">
    <div class="tinySizeHandler">
        <div class="desktopVersion fruitsInProfile mobile-hidden">
            <div class="orangeProfile">
                <img src="img/profileOrange.svg">
            </div>
            <div class="redProfile">
                <img src="img/profileRed.svg">
            </div>
            <div class="greenProfile">
                <img src="img/profileGreen.svg">
            </div>
        </div>
        <header class="mainHeader header-responsive organizer mobileVersion">
            <h1 class="heding-header font-size-18 boldFont redColor d-none">
                ازشنبه
            </h1>
            <div class="d-flex align-items-center">
                <div class="innerNav bag rightNavigationMenu rightFloat open-modal cursor-pointer ml-1 d-none" data-target=".panel-menu.bag">
                    <span class="icon icon-cart"></span>    
                </div>

                <div class="innerNav rightNavigationMenu rightFloat open-modal cursor-pointer" data-target=".panel-menu.dashbord">
                    <span class="icon icon-Menu"></span>
                    <span class="text">
                        پروفایل
                    </span>
    
                </div>
            </div>
            
        </header>

        <div class="tabStructureDesktop smallPaddingSpace organizer relative">
            <div class="tabs">
                {{-- <div class="tabHeader">
                    <div class="tabHeaderItem cursor-pointer" data-tab-c="dietMe">
                        <span class="activeLine"></span>
                        <span class="icon icon-diet middleContext"></span>
                        <a href="{{ route('dashboard.orders.index') }}">رژیم من</a>
                    </div>
                    <div class="tabHeaderItem cursor-pointer" data-tab-c="statusContent">
                        <span class="activeLine"></span>
                        <span class="icon icon-status middleContext"></span>
                        <a href="{{ route('dashboard.my-profiles.current-profile') }}">وضعیت من</a>
                    </div>
                    <div class="tabHeaderItem cursor-pointer" data-tab-c="addNewDiet">
                        <span class="activeLine"></span>
                        <span class="icon icon-heart middleContext"></span>
                        <a href="{{ route('dashboard.diets') }}">رژیم جدید</a>
                    </div>
                </div> --}}
                <div class="tabContent organizer textInCenter mxw-100 tabContent tabc mt-none">
                    <!--begin::content-->
                    {!! $content !!}
                    <!--end::content-->
                </div>
            </div>
        </div>

        <div class="menuOpen panel-menu dashbord">
            <div class="menuClose mobileVersion hidden cursor-pointer close-modal" data-target=".panel-menu.dashbord"></div>
            <div class="menuWhiteBox">
                <div class="logoAndClose mobileVersion">
                    <div class="AzShanbehLogo">
                        از شنبه
                    </div>
                    <div class="icon icon-close cursor-pointer close-modal" data-target=".panel-menu.dashbord"></div>
                </div>
                <div class="profileInfoBox">
                    <div class="profilePicture inlineView middleContext">
                        <img src="img/m.jpg">
                    </div>
                    <div class="nameAndPhone inlineView middleContext font-size-16 boldFont">
                        @php
                        $profile = \Facades\App\Libraries\ProfileHelper::getCurrentProfile();
                        @endphp
                        {{ $profile->name }}
                        @if(!empty($profile->user->mobile_number ))
                        <p class="font-size-14 boldFont">
                            {{ $profile->user->mobile_number }}
                        </p>
                        @endif
                    </div>
                    <div class="profileShape">
                        <img src="img/bottomProfileShape.svg">
                    </div>
                </div>
                <!--begin::sidebar-->
                @include('dashboard.layouts.sidebar')
                <!--end::sidebar-->
            </div>
            <!--begin::cart-->
            @include('dashboard.layouts.cart')
            <!--end::cart-->
        </div>

        <div class="menuOpen panel-menu d-none bag">
            <div class="menuClose mobileVersion hidden cursor-pointer close-modal" data-target=".panel-menu.bag"></div>
            <div class="menuWhiteBox">
                <div class="logoAndClose mobileVersion">
                    <div class="AzShanbehLogo">
                        از شنبه
                    </div>
                    <div class="icon icon-close cursor-pointer close-modal" data-target=".panel-menu.bag"></div>
                </div>
                <!--begin::cart-->
                     @include('dashboard.layouts.cart')
                <!--end::cart-->
            </div>
        
            
     
        </div>
    </div>

    <div class="popUpBox editProfile">
        <div class="popUpCloseBack hidden cursor-pointer close-modal" data-target=".editProfile"></div>
        <div class="popUpWhiteBox relative edit-profile-form">
            <div class="topRecentProfile organizer textInCenter">

                <img class="bottomProfileShape" src="img/bottomProfilePicture.svg">

                <div class="profilePicture">
                    <img src="img/profile.jpg">
                </div>
            </div>
            <div class="popUpBoxHeader font-size-18 boldFont organizer">
                <div class="popUpBoxTitle rightFloat">
                    ویرایش عکس
                </div>
                <div class="popUpBoxCross leftFloat">
                    <span class="pos-relative icon icon-close cursor-pointer close-modal" data-target=".editProfile"></span>
                </div>
            </div>
            <div class="popUpBoxContent font-size-14">
                <ul>
                    <li class="greenColor">
                        <span class="icon icon-newImage font-size-18"></span>
                        گرفتن عکس جدید
                    </li>
                    <li>
                        <span class="icon icon-art font-size-18"></span>
                        آپلود از گالری
                    </li>
                    <li class="redAlertColor">
                        <span class="icon icon-delete font-size-18"></span>
                        حذف عکس
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<a href="https://bit.ly/2XsNjDj" class="custom-support-btn" title="ارتباط با پشتیبان">
    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="30px" y="30px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
        <path style="fill:#FAFAFA;" d="M256.064,0h-0.128l0,0C114.784,0,0,114.816,0,256c0,56,18.048,107.904,48.736,150.048l-31.904,95.104
				l98.4-31.456C155.712,496.512,204,512,256.064,512C397.216,512,512,397.152,512,256S397.216,0,256.064,0z"></path>
        <path style="fill:#4CAF50;" d="M405.024,361.504c-6.176,17.44-30.688,31.904-50.24,36.128c-13.376,2.848-30.848,5.12-89.664-19.264
				C189.888,347.2,141.44,270.752,137.664,265.792c-3.616-4.96-30.4-40.48-30.4-77.216s18.656-54.624,26.176-62.304
				c6.176-6.304,16.384-9.184,26.176-9.184c3.168,0,6.016,0.16,8.576,0.288c7.52,0.32,11.396,0.768,16.256,12.64
				c6.176,14.88,21.216,51.616,23.008,55.392c1.824,3.776,3.648,8.896,1.088,13.856c-2.4,5.12-4.512,7.392-8.288,11.744
				c-3.776,4.352-7.36,7.68-11.136,12.352c-3.456,4.064-7.36,8.416-3.008,15.936c4.352,7.36,19.392,31.904,41.536,51.616
				c28.576,25.44,51.744,33.568,60.032,37.024c6.176,2.56,13.536,1.952,18.048-2.848c5.728-6.176,12.8-16.416,20-26.496
				c5.12-7.232,11.584-8.128,18.368-5.568c6.912,2.4,43.488,20.48,51.008,24.224c7.52,3.776,12.48,5.568,14.304,8.736
				C411.2,339.152,411.2,344.032,405.024,361.504z"></path>
    </svg>
</a>
@endsection