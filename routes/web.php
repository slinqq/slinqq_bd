<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SignupController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\Authenticated\CompanyController;
use App\Http\Controllers\Authenticated\ManagerController;
use App\Http\Controllers\Authenticated\MemberController;
use App\Http\Controllers\Authenticated\SectionController;
use App\Http\Controllers\Superadmin\DahboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CommonController::class, 'home'])->name('home');
Route::get('/about', [CommonController::class, 'about'])->name('about');
Route::get('/service', [CommonController::class, 'service'])->name('service');
Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'checkCredentials'])->name('login.store');
Route::get('/signup', [SignupController::class, 'index'])->name('signup.index');
Route::post('/signup', [SignupController::class, 'store'])->name('signup.store');
Route::get('/forgot-password', [LoginController::class, 'forgotPassword'])->name('forgot-password');
Route::post('/forgot-password', [LoginController::class, 'forgotPasswordStore'])->name('forgot-password.store');
Route::get('/password/reset/{token}', [LoginController::class, 'forgotPasswordUpdateForm'])->name('forgot-password.update.form');
Route::post('/password/reset/{token}', [LoginController::class, 'forgotPasswordUpdate'])->name('forgot-password.update');
Route::get('/get-cities/{country}', [CommonController::class, 'getCities'])->name('getcities');
Route::get('/generate-sitemap', [CommonController::class, 'generateSitemap'])->name('generate.sitemap');
Route::get('/email/verify/{id}/{hash}', [LoginController::class, 'verify'])
    ->name('verification.verify');
Route::get('/terms', [CommonController::class, 'terms'])->name('terms');

//user
Route::get('/search', [CommonController::class, 'getSearchCompanies'])->name('companies.emptyposition.search');
Route::get('/search-details/{companyId}', [CommonController::class, 'getSearchCompanyDetails'])->name('companies.emptyposition.search.details');

//Download attachment
Route::get('/download-attachment/{filename}', [CommonController::class, 'downloadAttachment'])
    ->name('download.attachment');
Route::get('/download-invoice-pdf/{paymentId}/{section_id}', [MemberController::class, 'downloadInvoicePdf']);



Route::middleware(['auth', 'check.token'])->group(function () {

    //Superadmin
    Route::prefix('superadmin')->middleware('isSuperAdmin')->group(function () {
        Route::get('/dashboard', [DahboardController::class, 'superadmin'])->name('superadmin');
        Route::get('/dashboard/manage/{userId}', [DahboardController::class, 'manageAdminUser'])->name('superadmin.manage');
        Route::put('/dashboard/manage/{userId}', [DahboardController::class, 'updateAdminUser'])->name('superadmin.manage.update');
    });

    Route::prefix('buildings')->group(function () {
        //admin or superadmin
        Route::middleware('isAdmin')->group(function () {
            Route::get('', [CompanyController::class, 'companies'])->name('companies');
            Route::get('company-add', [CompanyController::class, 'companyAddForm'])->name('company.add');
            Route::post('company-store', [CompanyController::class, 'store'])->name('company.store');

            //company id related
            Route::prefix('{companyId}')->group(function () {
                Route::get('building-manage', [CompanyController::class, 'show'])->name('company.manage');

                Route::prefix('floors')->group(function () {
                    Route::get('add', [SectionController::class, 'sectionAdd'])->name('section.add');
                    Route::post('store', [SectionController::class, 'sectionStore'])->name('section.store');
                    Route::delete('delete', [SectionController::class, 'sectionDelete'])->name('section.delete');

                    Route::prefix('{sectionId}/flat')->group(function () {
                        Route::get('add', [MemberController::class, 'memberAdd'])->name('member.add');
                        Route::post('store', [MemberController::class, 'memberStore'])->name('member.store');
                        Route::get('{memberId}', [MemberController::class, 'memberEdit'])->name('member.edit');
                        Route::put('{memberId}', [MemberController::class, 'memberUpdate'])->name('member.update');
                        Route::delete('{memberId}', [MemberController::class, 'memberDelete'])->name('member.delete');
                        Route::get('{memberId}/payment-create', [MemberController::class, 'memberPaymentAdd'])->name('member.payment.add');
                        Route::post('{memberId}/payment-store', [MemberController::class, 'memberPaymentStore'])->name('member.payment.store');
                        Route::delete('{memberId}/payment-remove/{paymentId}', [MemberController::class, 'memberPaymentRemove'])->name('member.payment.remove');
                    });
                });
            });


            //managers
            Route::prefix('managers')->group(function () {
                Route::get('', [ManagerController::class, 'managers'])->name('managers');
                Route::get('/assign', [ManagerController::class, 'managerAssignToCompany'])->name('companies.managers.add');
                Route::post('/assign', [ManagerController::class, 'managerAssignToCompanyStore'])->name('companies.managers.store');
                Route::get('/assign/{user}', [ManagerController::class, 'reAssignToCompany'])->name('companies.managers.reassign');
                Route::post('/assign/{user}', [ManagerController::class, 'reAssignToCompanyStore'])->name('companies.managers.reassign.store');
                Route::delete('/{managerId}/remove', [ManagerController::class, 'managerRemove'])->name('manager.remove');
            });
        });

        // Notification
        Route::middleware('isAdmin')->prefix('notifications')->group(function () {

            Route::get('/all', [CompanyController::class, 'notificationCompaniesAll'])->name('notification.companies.all');
            Route::post('/all', [CompanyController::class, 'notificationCompaniesAllSend'])->name('notification.companies.all.send');
            Route::get('/company/{companyId}/all-members', [CompanyController::class, 'notificationCompanyAll'])->name('notification.company.all');
            Route::post('/company/{companyId}/all-members', [CompanyController::class, 'notificationAllSend'])->name('notification.company.all.send');
            Route::get('/members/{memberId}', [CompanyController::class, 'notificationCompanySpecificMember'])->name('notification.specific.member.form');
            Route::post('/members/{memberId}', [CompanyController::class, 'notificationCompanySpecificMemberSend'])->name('notification.specific.member');
        });

        // payment
        Route::get('/companies/payment', [CompanyController::class, 'CheckPaymentCollection'])->name('companies.payment.collection');
    });

    //auth
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});
