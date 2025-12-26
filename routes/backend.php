<?php

use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\ChatController;
use App\Http\Controllers\Backend\FeedbackController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\ReportReasonController;
use App\Http\Controllers\Backend\ReportUserController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\Backend\TruckManageController;
use App\Http\Controllers\Contact\ContactSectionController;
use App\Http\Controllers\Contact\ContactSubmissionAdminController;
use App\Http\Controllers\Dynamic\DynamicPageController;
use App\Http\Controllers\Faq\FaqController;
use App\Http\Controllers\Faq\FaqSectionController;
use App\Http\Controllers\Footer\FooterController;
use App\Http\Controllers\Gallery\GalleryController;
use App\Http\Controllers\Gallery\GallerySectionController;
use App\Http\Controllers\HeroSection\HeroSectionController;
use App\Http\Controllers\Navbar\NavbarController;
use App\Http\Controllers\ProcessStep\ProcessStepController;
use App\Http\Controllers\RolePermission\PermissionController;
use App\Http\Controllers\RolePermission\RoleController;
use App\Http\Controllers\RolePermission\RolePermissionController;
use App\Http\Controllers\RolePermission\UserController;
use App\Http\Controllers\ServicePackages\ServicePackageController;
use App\Http\Controllers\Settings\AdminSettingsController;
use App\Http\Controllers\Settings\MailSettingController;
use App\Http\Controllers\Settings\ProfileSettingController;
use App\Http\Controllers\Settings\SystemController;
use App\Http\Controllers\Testimonial\TestimonialController;
use App\Http\Controllers\Testimonial\TestimonialSectionController;
use App\Http\Controllers\WhyUsPanel\WhyUsPanelController;
use Illuminate\Support\Facades\Route;




// Ompa Portion

// navbar management
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('navbar', [NavbarController::class, 'index'])->name('navbar.index');
    Route::post('navbar', [NavbarController::class, 'update'])->name('navbar.update');
    Route::get('navbar/nav-items', [NavbarController::class, 'navItems'])->name('navbar.navItems');
    Route::post('navbar/nav-items', [NavbarController::class, 'navItemStore'])->name('navbar.navItemStore');
    Route::put('navbar/nav-items/{id}', [NavbarController::class, 'navItemUpdate'])->name('navbar.navItemUpdate');
    Route::delete('navbar/nav-items/{id}', [NavbarController::class, 'navItemDelete'])->name('navbar.navItemDelete');
});

// Service Package Management

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('service-packages', [ServicePackageController::class, 'index'])->name('admin.service-packages.index');
    Route::post('service-packages', [ServicePackageController::class, 'store'])->name('admin.service-packages.store');
    Route::put('service-packages/{servicePackage}', [ServicePackageController::class, 'update'])->name('admin.service-packages.update');
    Route::delete('service-packages/{servicePackage}', [ServicePackageController::class, 'destroy'])->name('admin.service-packages.destroy');
    Route::get('service-package-section', [ServicePackageController::class, 'sectionEdit'])->name('service-package-section.edit');
    Route::post('service-package-section-update', [ServicePackageController::class, 'sectionUpdate'])->name('service-package-section.update');

});

// why us panel management
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::resource('why-us-panels', WhyUsPanelController::class);
});

// process step management
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::resource('process-steps', ProcessStepController::class);
    Route::get('process-step-section', [ProcessStepController::class, 'sectionEdit'])->name('process-step-section.edit');
    Route::post('process-step-section-update', [ProcessStepController::class, 'sectionUpdate'])->name('process-step-section.update');

});
// gallery management

Route::prefix('admin')->middleware(['auth'])->group(function () {

    // Gallery Section Update
    Route::post('gallery-section/update', [GallerySectionController::class, 'update'])
        ->name('gallery-section.update');

    // DataTable Ajax route - MUST be above resource
    Route::get('galleries/data', [GalleryController::class, 'getData'])
        ->name('galleries.data');

    // Resource CRUD
    Route::resource('galleries', GalleryController::class);
});
// testimonial management
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::post('testimonial-section/update', [TestimonialSectionController::class, 'update'])->name('testimonial-section.update');
    Route::resource('testimonials', TestimonialController::class);
});
// faq management
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::post('faq-section/update', [FaqSectionController::class, 'update'])->name('faq-section.update');
    Route::resource('faqs', FaqController::class);
});
// contact section management
Route::prefix('admin')->middleware(['auth'])->group(function () {
    // Show edit page for all contact settings
    Route::get('contact-section/edit', [ContactSectionController::class, 'edit'])->name('contact-section.edit');

    // Update section title, subtitle, description
    Route::put('contact-sections/update/{id}', [ContactSectionController::class, 'updateSection'])->name('contact-sections.update');

    // Contact Fields CRUD
    Route::put('contact-fields/update/{id}', [ContactSectionController::class, 'updateField'])->name('contact-fields.update');
    Route::post('contact-fields/store', [ContactSectionController::class, 'storeField'])->name('contact-fields.store');
    // Route::delete('contact-fields/destroy/{id}', [ContactSectionController::class, 'destroyField'])->name('contact-fields.destroy');
    Route::post('contact-fields/destroy/{id}', [ContactSectionController::class, 'destroyField'])->name('contact-fields.destroy');

    // Contact Areas CRUD (dropdown options)
    Route::put('contact-areas/update/{id}', [ContactSectionController::class, 'updateArea'])->name('contact-areas.update');
    Route::post('contact-areas/store', [ContactSectionController::class, 'storeArea'])->name('contact-areas.store');
    Route::delete('contact-areas/destroy/{id}', [ContactSectionController::class, 'destroyArea'])->name('contact-areas.destroy');

    // Contact Card info update
    Route::put('contact-cards/update/{id}', [ContactSectionController::class, 'updateCard'])->name('contact-cards.update');

    Route::get('contact-submissions', [ContactSubmissionAdminController::class, 'index'])->name('contact-submissions.index');

        
});
// footer management
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('footer/edit', [FooterController::class, 'edit'])->name('footer-settings.edit');
    Route::put('footer/update/{id}', [FooterController::class, 'update'])->name('footer-settings.update');
    Route::get('footer/edit', [FooterController::class, 'links'])->name('footer-settings.edit');
    Route::post('footer-links/store', [FooterController::class, 'storeLink'])->name('footer-links.store');
    Route::put('footer-links/{link}', [FooterController::class, 'updateLink'])->name('footer-links.update');
    Route::delete('footer-links/{link}', [FooterController::class, 'destroyLink'])->name('footer-links.destroy');
    Route::put('footer-settings/{footer}', [FooterController::class, 'update'])->name('footer-settings.update');
});

Route::get('admin/hero-section', [HeroSectionController::class, 'edit'])->name('admin.hero-section.edit');
Route::post('admin/hero-section', [HeroSectionController::class, 'update'])->name('admin.hero-section.update');

Route::controller(BackendController::class)->middleware('auth.check')->group(function () {
    Route::get('/', 'index')->name('dashboard');
    Route::get('/dashboard-data', 'monthlyData');
});

// Role and Permission Management start
Route::controller(RoleController::class)->middleware('auth.check')->group(function () {
    Route::get('/role/index', 'index')->name('role.index');
    Route::post('/role/store', 'store')->name('role.store');
    Route::get('/role/destroy/{id}', 'destroy')->name('role.destroy');
    Route::get('/role/edit/{id}', 'edit')->name('role.edit');
    Route::put('/role/update/{id}', 'update')->name('role.update');
    Route::get('/permission/edit/{id}', 'editPermission')->name('permission.edit');
});

Route::controller(RolePermissionController::class)->middleware('auth.check')->group(function () {});

Route::controller(UserController::class)->middleware('auth.check')->group(function () {
    Route::get('/user/index', 'index')->name('user.index');
    Route::post('/user/store', 'store')->name('user.store');
    Route::get('/user/edit/{id}', 'edit')->name('user.edit');
    Route::put('/user/update/{id}', 'update')->name('user.update');
    Route::get('/user/destroy/{id}', 'destroy')->name('user.destroy');
    Route::get('/user/show/{id}', 'show')->name('user.show');
    Route::get('/user/role/change/{id}', 'ChangeRole')->name('user.role.change');
    Route::post('/user/role/Update/{id}', 'assignRoleUpate')->name('user.role.update');
});

Route::controller(PermissionController::class)->middleware('auth.check')->group(function () {
    Route::get('/permission/index', 'index')->name('permission.index');
    Route::post('/permission/store', 'store')->name('permission.store');
    // Route::get('/permission/destroy/{id}', 'destroy')->name('permission.destroy');
    Route::post('role/permission/update/{id}', 'UpdatePermissionByRole')->name('role.permission.update');
});

// settings Management start
Route::controller(MailSettingController::class)->middleware('auth.check')->group(function () {
    Route::get('/settings/mail', 'index')->name('mail.index');
    Route::post('/settings/mail-store', 'mailstore')->name('mail.store');
});

Route::controller(ProfileSettingController::class)->middleware('auth.check')->group(function () {
    Route::get('/settings/profile', 'index')->name('profile.index');
    Route::post('/settings/profile-update', 'profileupdate')->name('profile.update');
    Route::post('/settings/profile-password-update', 'PasswordUpdate')->name('profile.password.update');
});

Route::controller(SystemController::class)->middleware('auth.check')->group(function () {
    Route::get('/settings/system', 'index')->name('system.index');
    Route::post('/settings/system-store', 'systemupdate')->name('system.update');
    Route::post('/settings/social-store', 'updateSocials')->name('social.update');
});

Route::controller(AdminSettingsController::class)->middleware('auth.check')->group(function () {
    Route::get('/settings/admin', 'index')->name('admin.setting.index');
    Route::post('/settings/admin/update', 'adminSettingUpdate')->name('admin.setting.update');
});

// dynamic page management start
Route::controller(DynamicPageController::class)->middleware('auth.check')->group(function () {
    Route::resource('dynamic-pages', DynamicPageController::class);
    Route::get('/dynamic/pages/destroy/{id}', 'destroy')->name('dynamic-pages.delete');
    Route::get('/dynamic/pages/toggle-status/{id}/{status}', 'pageSatus')->name('dynamic-pages.toggleStatus');
});
