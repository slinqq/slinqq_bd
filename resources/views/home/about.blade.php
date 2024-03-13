@extends('layouts.master')

@section('title', 'About Us')

@section('description', 'Building Management System. A web application for managing members of an organization.')

@section('content')
<!-- Include the alerts file -->
@include('layouts.alerts')

<section class="section-padding bg-image">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-10 col-12 mx-auto mb-4">
                <h2 class="mb-5 text-center">About Us</h2>
                <p class="lead">

<p class="lead text-center">How it works:</p>

    <p>1. you have to sign up as admin.</p>

    <p>2. you have to add your building by filling building information form. You can add building as many as you want.</p>

    <p>3. you have to add your floor by floor name.</p>

    <p> 4. You have to add your flat by flat name with flat member information.</p>
  
    <p>5. That's all. Now you can manage your building from here.</p>

    <p>6. If you want to add your manager here for managing your account, you can also do it from here.</p>  

    <p>7. You can add as many manager as you want.</p>


   <p class="lead text-center"> What you can do & your benefit:</p>


   <p>1. Your building member information will be stored here.</p>

   <p>2. You can edit, update and delete anytime from here.</p>

   <p>3. You can see your information by login here.</p>

   <p>4. When a member of your building, pay the rent of flat, you can add here.</p>

   <p>5. You can see who complete payment, who didn't.</p>

   <p>6. When you add a rent of a member, Member will be notified by email with a payment slip(Notify by sms is coming).</p>

   <p>7. You can also add your empty flat here.</p>
 
   <p>8. When you add your empty flat, it will show to the website, so that customer can contact to rent the flat.</p>

   <p>9. You can also add manager to manage your building information.</p>

   <p>10. You can add as many as manager you want.</p>
   
   <p>11. You can give notice any member of your building by email.</p>

   <p>12. You can give notice all member at once by email.</p>

   <h2 class="mb-5 text-center">Important!</h2>

   <p> After sign in, you will be a member of our family. You can use your account for free 3 months (may extend another 3 months).
       After that you have to pay a minimum amount for a month for your account. 
       If you get trouble to manage your account or face any difficulties or any suggestion, 
       contact us in the number (+8801537403196) or email to sayeedakib6009@gmail.com
   </p>

  </p>

            </div>
        </div>
    </div>
</section>

@endsection