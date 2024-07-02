@if(!empty($company->logo))
    <div style="display: flex; justify-content: center; align-items: center;" style="text-align: center">
        <img class="" src="{{ asset('storage/logos/'.$company->logo) }}" alt="Logo" style="height: 40px; margin-right: 10px; margin-top: 18px;">
    </div>   
@endif
<p class="text-center text-danger" >
    <b>{{$company->name}}</b>
</p>
<p class="text-center">
    <span style="font-size: 15px;">{{$company->address}}</span> <br>
    <span style="font-size: 15px;">{{$company->tel_no}}</span>  <br>
    <span style="font-size: 15px;">SSN: {{$company->ssni_est}}</span>
</p>
