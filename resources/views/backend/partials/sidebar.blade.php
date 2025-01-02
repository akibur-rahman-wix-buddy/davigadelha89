@php

    $system = \App\Models\SystemSetting::first();

@endphp



<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper">
            <a href="{{ route('dashboard') }}">
                @if (!empty($system->logo))
                    {{--                                        <img class="img-fluid for-light" height="60px" src="{{ asset($system->logo ?? "") }}" alt=""/> --}}
                    <img class="mb-3 w-auto" height="60px" src="{{ asset($system->logo ?? '') }}" alt="logo" />
                @else
                    {{--                    <img class="img-fluid for-light" src="{{asset('backend/images/logo/image 13.png')}}" alt=""> --}}
                    <img class="mb-3 w-auto" height="60px" src="{{ asset('backend/images/logo/image 13.png') }}"
                        alt="">
                @endif
            </a>
            <div class="back-btn"><i data-feather="grid"></i></div>
            <div class="toggle-sidebar icon-box-sidebar"><i class="status_toggle middle sidebar-toggle"
                    data-feather="grid"> </i></div>
        </div>
        <div class="logo-icon-wrapper"><a href="index.html">
                <div class="icon-box-sidebar"><i data-feather="grid"></i></div>
            </a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn">
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>
                    <li class="pin-title sidebar-list">
                        <h6>Pinned</h6>
                    </li>
                    <hr>

                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                            class="sidebar-link {{ Request::routeIs('dashboard') ? 'active open' : ' ' }}"
                            href="{{ route('dashboard') }}"><i data-feather="home"></i><span
                                class="lan-3">Dashboard</span></a>
                    </li>

                    {{--                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title {{ Request::routeIs('cms.*') ? 'active open' : ' ' }}" href="javascript:void(0)"><i data-feather="layers"></i><span>CMS</span></a> --}}
                    {{--                        <ul class="sidebar-submenu"> --}}
                    {{--                            <li><a class="submenu-title {{ Request::routeIs('cms.home-page.*') ? 'active open' : '' }}" href="javascript:void(0)">Home Page<span class="sub-arrow"><i class="fa fa-angle-right"></i></span></a> --}}
                    {{--                                <ul class="nav-sub-childmenu submenu-content"> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('cms.home-page.home-section') ? 'active' : ' ' }}" href="{{route('cms.home-page.home-section')}}">Home Section</a></li> --}}
                    {{--                                </ul> --}}
                    {{--                            </li> --}}

                    {{--                            <li><a class="submenu-title {{ Request::routeIs('cms.business-home-page.*') ? 'active open' : '' }}" href="javascript:void(0)">Business Page<span class="sub-arrow"><i class="fa fa-angle-right"></i></span></a> --}}
                    {{--                                <ul class="nav-sub-childmenu submenu-content"> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('cms.business-home-page.section-one') ? 'active' : ' ' }}" href="{{route('cms.business-home-page.section-one')}}">Section One</a></li> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('cms.business-home-page.section-two') ? 'active' : ' ' }}" href="{{route('cms.business-home-page.section-two')}}">Section Two</a></li> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('cms.business-home-page.section-three') ? 'active' : ' ' }}" href="{{route('cms.business-home-page.section-three')}}">Section Three</a></li> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('cms.business-home-page.section-four') ? 'active' : ' ' }}" href="{{route('cms.business-home-page.section-four')}}">Section Four</a></li> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('cms.business-home-page.section-five') ? 'active' : ' ' }}" href="{{route('cms.business-home-page.section-five')}}">Section Five</a></li> --}}
                    {{--                                </ul> --}}
                    {{--                            </li> --}}

                    {{--                            <li><a class="submenu-title {{ Request::routeIs('cms.humans-home-page.*') ? 'active open' : '' }}" href="javascript:void(0)">Humans Page<span class="sub-arrow"><i class="fa fa-angle-right"></i></span></a> --}}
                    {{--                                <ul class="nav-sub-childmenu submenu-content"> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('cms.humans-home-page.section-one') ? 'active' : ' ' }}" href="{{route('cms.humans-home-page.section-one')}}">Section One</a></li> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('cms.humans-home-page.section-two') ? 'active' : ' ' }}" href="{{route('cms.humans-home-page.section-two')}}">Section Two</a></li> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('cms.humans-home-page.section-three') ? 'active' : ' ' }}" href="{{route('cms.humans-home-page.section-three')}}">Section Three</a></li> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('cms.humans-home-page.section-four') ? 'active' : ' ' }}" href="{{route('cms.humans-home-page.section-four')}}">Section Four</a></li> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('cms.humans-home-page.section-five') ? 'active' : ' ' }}" href="{{route('cms.humans-home-page.section-five')}}">Section Five</a></li> --}}
                    {{--                                </ul> --}}
                    {{--                            </li> --}}

                    {{--                            <li><a class="submenu-title {{ Request::routeIs('cms.get-the-app.*') ? 'active open' : '' }}" href="javascript:void(0)">Get The App<span class="sub-arrow"><i class="fa fa-angle-right"></i></span></a> --}}
                    {{--                                <ul class="nav-sub-childmenu submenu-content"> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('cms.get-the-app.section-one') ? 'active' : ' ' }}" href="{{route('cms.get-the-app.section-one')}}">Section One</a></li> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('cms.get-the-app.section-two') ? 'active' : ' ' }}" href="{{route('cms.get-the-app.section-two')}}">Section Two</a></li> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('cms.get-the-app.section-three') ? 'active' : ' ' }}" href="{{route('cms.get-the-app.section-three')}}">Section Three</a></li> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('cms.get-the-app.section-four') ? 'active' : ' ' }}" href="{{route('cms.get-the-app.section-four')}}">Section Four</a></li> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('cms.get-the-app.section-five') ? 'active' : ' ' }}" href="{{route('cms.get-the-app.section-five')}}">Section Five</a></li> --}}
                    {{--                                </ul> --}}
                    {{--                            </li> --}}

                    {{--                            <li><a class="submenu-title {{ Request::routeIs('cms.why-zally.*') ? 'active open' : '' }}" href="javascript:void(0)">Why Zally<span class="sub-arrow"><i class="fa fa-angle-right"></i></span></a> --}}
                    {{--                                <ul class="nav-sub-childmenu submenu-content"> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('cms.why-zally.section-one') ? 'active' : ' ' }}" href="{{route('cms.why-zally.section-one')}}">Section One</a></li> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('cms.why-zally.section-two') ? 'active' : ' ' }}" href="{{route('cms.why-zally.section-two')}}">Section Two</a></li> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('cms.why-zally.section-three') ? 'active' : ' ' }}" href="{{route('cms.why-zally.section-three')}}">Section Three</a></li> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('cms.why-zally.section-four') ? 'active' : ' ' }}" href="{{route('cms.why-zally.section-four')}}">Section Four</a></li> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('cms.why-zally.section-five') ? 'active' : ' ' }}" href="{{route('cms.why-zally.section-five')}}">Section Five</a></li> --}}
                    {{--                                </ul> --}}
                    {{--                            </li> --}}

                    {{--                            <li><a class="submenu-title {{ Request::routeIs('cms.how-it-works-business.*') ? 'active open' : '' }}" href="javascript:void(0)">How It Works Business<span class="sub-arrow"><i class="fa fa-angle-right"></i></span></a> --}}
                    {{--                                <ul class="nav-sub-childmenu submenu-content"> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('cms.how-it-works-business.section-one') ? 'active' : ' ' }}" href="{{route('cms.how-it-works-business.section-one')}}">Section One</a></li> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('cms.how-it-works-business.section-two') ? 'active' : ' ' }}" href="{{route('cms.how-it-works-business.section-two')}}">Section Two</a></li> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('cms.how-it-works-business.section-three') ? 'active' : ' ' }}" href="{{route('cms.how-it-works-business.section-three')}}">Section Three</a></li> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('cms.how-it-works-business.section-four') ? 'active' : ' ' }}" href="{{route('cms.how-it-works-business.section-four')}}">Section Four</a></li> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('cms.how-it-works-business.section-five') ? 'active' : ' ' }}" href="{{route('cms.how-it-works-business.section-five')}}">Section Five</a></li> --}}
                    {{--                                </ul> --}}
                    {{--                            </li> --}}

                    {{--                        </ul> --}}
                    {{--                    </li> --}}

                    {{--                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title {{ Request::routeIs('social-links') ? 'active open' : ' ' }}" href="javascript:void(0)"><i data-feather="zap"></i><span>Social</span></a> --}}
                    {{--                        <ul class="sidebar-submenu"> --}}
                    {{--                            <li><a class="{{ Request::routeIs('social-links') ? 'active' : ' ' }}" href="{{route('social-links')}}">Social Links</a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}

                    {{--                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title {{ Request::routeIs('data-tables.*') ? 'active open' : ' ' }}" href="javascript:void(0)"><i data-feather="server"></i><span>Tables</span></a> --}}
                    {{--                        <ul class="sidebar-submenu"> --}}
                    {{--                            <li><a class="submenu-title {{ Request::routeIs('data-tables.*') ? 'active open' : ' ' }}" href="javascript:void(0)">Data Tables<span class="sub-arrow"><i class="fa fa-angle-right"></i></span></a> --}}
                    {{--                                <ul class="nav-sub-childmenu submenu-content"> --}}
                    {{--                                    <li><a class="{{ Request::routeIs('data-tables.basic') ? 'active' : ' ' }}" href="{{route('data-tables.basic')}}">Basic Table</a></li> --}}
                    {{--                                </ul> --}}
                    {{--                            </li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}


                    {{--                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title {{ Request::routeIs('category.*') ? 'active open' : ' ' }}" href="javascript:void(0)"><i data-feather="box"></i><span>Category</span></a> --}}
                    {{--                        <ul class="sidebar-submenu"> --}}
                    {{--                            <li><a class="{{ Request::routeIs('category.index') ? 'active' : ' ' }}" href="{{route('category.index')}}">Category Details</a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}

                    {{--                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title {{ Request::routeIs('brand.*') ? 'active open' : ' ' }}" href="javascript:void(0)"><i data-feather="bold"></i><span>Brand</span></a> --}}
                    {{--                        <ul class="sidebar-submenu"> --}}
                    {{--                            <li><a class="{{ Request::routeIs('brand.index') ? 'active' : ' ' }}" href="{{route('brand.index')}}">Brand Details</a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}

                    {{--                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title {{ Request::routeIs('designer.*') ? 'active open' : ' ' }}" href="javascript:void(0)"><i data-feather="aperture"></i><span>Designer</span></a> --}}
                    {{--                        <ul class="sidebar-submenu"> --}}
                    {{--                            <li><a class="{{ Request::routeIs('designer.index') ? 'active' : ' ' }}" href="{{route('designer.index')}}">Designer Details</a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}

                    {{--                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title {{ Request::routeIs('product.*') ? 'active open' : ' ' }}" href="javascript:void(0)"><i data-feather="shopping-bag"></i><span>Products</span></a> --}}
                    {{--                        <ul class="sidebar-submenu"> --}}
                    {{--                            <li><a class="{{ Request::routeIs('product.index') ? 'active' : ' ' }}" href="{{route('product.index')}}">Product List</a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}

                    {{--                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title {{ Request::routeIs('product-detail.*') ? 'active open' : ' ' }}" href="javascript:void(0)"><i data-feather="film"></i><span>Product Detail</span></a> --}}
                    {{--                        <ul class="sidebar-submenu"> --}}
                    {{--                            <li><a class="{{ Request::routeIs('product-detail.index') ? 'active' : ' ' }}" href="{{route('product-detail.index')}}">Product Detail</a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}

                    {{-- this is for order management --}}
                    {{--                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title {{ Request::routeIs('order.*') ? 'active open' : ' ' }}" href="javascript:void(0)"><i data-feather="shopping-cart"></i><span>Product Order</span></a> --}}
                    {{--                        <ul class="sidebar-submenu"> --}}
                    {{--                            <li><a class="{{ Request::routeIs('order.index') ? 'active' : ' ' }}" href="{{route('order.index')}}">Order Management</a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}

                    {{--                    --}}{{-- this is for contact --}}
                    {{--                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title {{ Request::routeIs('contact.*') ? 'active open' : ' ' }}" href="javascript:void(0)"><i data-feather="phone"></i><span>Contacts</span></a> --}}
                    {{--                        <ul class="sidebar-submenu"> --}}
                    {{--                            <li><a class="{{ Request::routeIs('contact.index') ? 'active' : ' ' }}" href="{{route('contact.index')}}">Contact List</a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}

                    {{--                    --}}{{-- this is for quote --}}
                    {{--                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title {{ Request::routeIs('quote.*') ? 'active open' : ' ' }}" href="javascript:void(0)"><i data-feather="message-circle"></i><span>Quotes</span></a> --}}
                    {{--                        <ul class="sidebar-submenu"> --}}
                    {{--                            <li><a class="{{ Request::routeIs('quote.index') ? 'active' : ' ' }}" href="{{route('quote.index')}}">Quote List</a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}


                    {{--                    --}}{{-- this is for newsletter subscription --}}
                    {{--                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title {{ Request::routeIs('subscription.*') ? 'active open' : ' ' }}" href="javascript:void(0)"><i data-feather="mail"></i><span>Subscriptions</span></a> --}}
                    {{--                        <ul class="sidebar-submenu"> --}}
                    {{--                            <li><a class="{{ Request::routeIs('subscription.index') ? 'active' : ' ' }}" href="{{route('subscription.index')}}">Subscription List</a></li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}









                    {{-- added by masum --}}
                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                            class="sidebar-link sidebar-title {{ Request::routeIs('category.*') ? 'active open' : ' ' }}"
                            href="javascript:void(0)"><i data-feather="box"></i><span>Course Category</span></a>
                        <ul class="sidebar-submenu">
                            <li><a class="{{ Request::routeIs('category.index') ? 'active' : ' ' }}"
                                    href="{{ route('category.index') }}">Category Lists</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                            class="sidebar-link sidebar-title {{ Request::routeIs('course.*') ? 'active open' : ' ' }}"
                            href="javascript:void(0)"><i data-feather="box"></i><span>Courses</span></a>
                        <ul class="sidebar-submenu">
                            <li><a class="{{ Request::routeIs('course.index') ? 'active' : ' ' }}"
                                    href="{{ route('course.index') }}">Course Lists</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                            class="sidebar-link sidebar-title {{ Request::routeIs('pdf.*') ? 'active open' : ' ' }}"
                            href="javascript:void(0)"><i data-feather="box"></i><span>Agreement File</span></a>
                        <ul class="sidebar-submenu">
                            <li><a class="{{ Request::routeIs('pdf.index') ? 'active' : ' ' }}"
                                   href="{{ route('pdf.index') }}">PDF Lists</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                            class="sidebar-link sidebar-title {{ Request::routeIs('settings.*') ? 'active open' : '' }}"
                            href="javascript:void(0)"><i data-feather="settings"></i><span>Settings</span></a>
                        <ul class="sidebar-submenu">
                            <li><a class="{{ Request::routeIs('settings.profile') ? 'active' : '' }}"
                                    href="{{ route('settings.profile') }}">Profile Settings</a></li>
                            <li><a class="{{ Request::routeIs('settings.system.index') ? 'active' : ' ' }}"
                                    href="{{ route('settings.system.index') }}">System Settings</a></li>
                            <li><a class="{{ Request::routeIs('settings.mail') ? 'active' : ' ' }}"
                                    href="{{ route('settings.mail') }}">Mail Settings</a></li>
                            <li><a class="{{ Request::routeIs('settings.stripe.index') ? 'active' : ' ' }}"
                                    href="{{ route('settings.stripe.index') }}">Stripe Settings</a></li>
                            <li><a class="{{ Request::routeIs('settings.dynamic-page.index') || Request::routeIs('settings.dynamic-page.create') || Request::routeIs('settings.dynamic-page.edit') ? 'active' : ' ' }}"
                                    href="{{ route('settings.dynamic-page.index') }}">Dynamic Page Settings</a></li>
                            <li><a class="{{ Request::routeIs('settings.custom-script.*') ? 'active' : ' ' }}"
                                    href="{{ route('settings.custom-script.index') }}">Custom Script Settings</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
