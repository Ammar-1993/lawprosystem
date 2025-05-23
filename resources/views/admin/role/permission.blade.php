@extends('admin.layout.app')
@section('title','Role')
@push('style')

@endpush
@section('content')
   <div class="">
     @component('component.heading' , [

    'page_title' => __('frontend.permissions'),
    'action' => route('role.index') ,
    'text' => __('frontend.back'),
     ])
    @endcomponent
      <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                  <form action="{{ route('permission.update',$role_id) }}"  method="post" name="product_type_attribute_form" id="product_type_attribute_form" enctype="multipart/form-data" class="m-form m-form--fit m-form--label-align-right">

                                      @csrf @method('PUT')
                <div class="x_panel">
                  <div class="x_content">

                    <table class="table">
                        <thead>
                          <tr>
                            <th width="30%">{{__('frontend.menu')}}</th>
                            <th width="30%">{{__('frontend.sub_menu')}}</th>

                            <th width="10%"><input class="all_view" type="checkbox">&nbsp; {{__('frontend.view')}} </th>
                            <th width="10%"> <input class="all_add" type="checkbox">&nbsp; {{__('frontend.add')}}</th>
                            <th width="10%"> <input class="all_edit" type="checkbox">&nbsp; {{__('frontend.edit')}}</th>
                            <th width="10%"> <input class="all_delete" type="checkbox">&nbsp; {{__('frontend.delete')}}</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr class="tr_permition">
                            <td>{{__('frontend.dashboard1')}}</td>

                            <td>-</td>
                            <td>
                           <label class="m-checkbox m-checkbox--brand"><input class="permition_view" type="checkbox" value="1" name="permission[]" {{ ($permissions_array->contains('1')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                           </td>
                            <td>
                              -
                            </td>
                            <td>
                              -
                            </td>
                            <td>
                              -
                            </td>
                          </tr>
                          <tr  class="tr_permition">
                            <td>{{__('frontend.clientf')}}</td>

                            <td>-</td>
                            <td>
                           <label class="m-checkbox m-checkbox--brand "><input class="permition_view" type="checkbox" value="2" name="permission[]" {{ ($permissions_array->contains('2')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                           </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_add" type="checkbox" value="3" name="permission[]" {{ ($permissions_array->contains('3')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input  class="permition_edit" type="checkbox" value="4" name="permission[]" {{ ($permissions_array->contains('4')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_delete" type="checkbox" value="5" name="permission[]" {{ ($permissions_array->contains('5')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                          </tr>
                          <tr  class="tr_permition">
                            <td>{{__('frontend.task1')}}</td>

                            <td>-</td>
                            <td>
                           <label class="m-checkbox m-checkbox--brand"><input class="permition_view" type="checkbox" value="6" name="permission[]" {{ ($permissions_array->contains('6')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                           </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_add" type="checkbox" value="7" name="permission[]" {{ ($permissions_array->contains('7')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input  class="permition_edit" type="checkbox" value="8" name="permission[]" {{ ($permissions_array->contains('8')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_delete" type="checkbox" value="9" name="permission[]" {{ ($permissions_array->contains('9')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                          </tr>
                          <tr  class="tr_permition">
                            <td>{{__('frontend.vendor1')}}</td>

                            <td>-</td>
                            <td>
                           <label class="m-checkbox m-checkbox--brand"><input class="permition_view" type="checkbox" value="10" name="permission[]" {{ ($permissions_array->contains('10')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                           </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_add" type="checkbox" value="11" name="permission[]" {{ ($permissions_array->contains('11')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input  class="permition_edit" type="checkbox" value="12" name="permission[]" {{ ($permissions_array->contains('12')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_delete" type="checkbox" value="13" name="permission[]" {{ ($permissions_array->contains('13')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                          </tr>
                            <tr  class="tr_permition">
                            <td>{{__('frontend.case')}}</td>

                            <td>-</td>
                            <td>
                           <label class="m-checkbox m-checkbox--brand"><input class="permition_view" type="checkbox" value="14" name="permission[]" {{ ($permissions_array->contains('14')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                           </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_add" type="checkbox" value="15" name="permission[]" {{ ($permissions_array->contains('15')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input  class="permition_edit" type="checkbox" value="16" name="permission[]" {{ ($permissions_array->contains('16')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                               -
                            </td>
                          </tr>
                          <tr  class="tr_permition">
                            <td>{{__('frontend.appointment1')}}</td>

                            <td>-</td>
                            <td>
                           <label class="m-checkbox m-checkbox--brand"><input class="permition_view" type="checkbox" value="17" name="permission[]" {{ ($permissions_array->contains('17')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                           </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_add" type="checkbox" value="18" name="permission[]" {{ ($permissions_array->contains('18')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input  class="permition_edit" type="checkbox" value="19" name="permission[]" {{ ($permissions_array->contains('19')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                                -
                            </td>
                          </tr>
                             <tr  class="tr_permition">
                            <td>{{__('frontend.expense')}}</td>

                            <td>{{__('frontend.expense_type')}}</td>
                            <td>
                           <label class="m-checkbox m-checkbox--brand"><input class="permition_view" type="checkbox" value="20" name="permission[]" {{ ($permissions_array->contains('20')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                           </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_add" type="checkbox" value="21" name="permission[]" {{ ($permissions_array->contains('21')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input  class="permition_edit" type="checkbox" value="22" name="permission[]" {{ ($permissions_array->contains('22')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_delete" type="checkbox" value="23" name="permission[]" {{ ($permissions_array->contains('23')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                          </tr>
                            <tr  class="tr_permition">
                            <td></td>

                            <td>{{__('frontend.expense')}}</td>
                            <td>
                           <label class="m-checkbox m-checkbox--brand"><input class="permition_view" type="checkbox" value="24" name="permission[]" {{ ($permissions_array->contains('24')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                           </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_add" type="checkbox" value="25" name="permission[]" {{ ($permissions_array->contains('25')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input  class="permition_edit" type="checkbox" value="26" name="permission[]" {{ ($permissions_array->contains('26')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_delete" type="checkbox" value="27" name="permission[]" {{ ($permissions_array->contains('27')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                          </tr>


                          <tr  class="tr_permition">
                            <td>{{__('frontend.income')}}</td>

                            <td>{{__('frontend.service')}}</td>
                            <td>
                           <label class="m-checkbox m-checkbox--brand"><input class="permition_view" type="checkbox" value="59" name="permission[]" {{ ($permissions_array->contains('59')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                           </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_add" type="checkbox" value="60" name="permission[]" {{ ($permissions_array->contains('60')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input  class="permition_edit" type="checkbox" value="61" name="permission[]" {{ ($permissions_array->contains('61')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_delete" type="checkbox" value="62" name="permission[]" {{ ($permissions_array->contains('62')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                          </tr>

                           <tr  class="tr_permition">
                            <td></td>

                            <td>{{__('frontend.invoice')}}</td>
                            <td>
                           <label class="m-checkbox m-checkbox--brand"><input class="permition_view" type="checkbox" value="28" name="permission[]" {{ ($permissions_array->contains('28')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                           </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_add" type="checkbox" value="29" name="permission[]" {{ ($permissions_array->contains('29')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input  class="permition_edit" type="checkbox" value="30" name="permission[]" {{ ($permissions_array->contains('30')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_delete" type="checkbox" value="31" name="permission[]" {{ ($permissions_array->contains('31')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                          </tr>



                            <tr  class="tr_permition">
                            <td>{{__('frontend.settings')}}</td>

                            <td>{{__('frontend.case_type')}}</td>
                            <td>
                           <label class="m-checkbox m-checkbox--brand"><input class="permition_view" type="checkbox" value="32" name="permission[]" {{ ($permissions_array->contains('32')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                           </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_add" type="checkbox" value="33" name="permission[]" {{ ($permissions_array->contains('33')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input  class="permition_edit" type="checkbox" value="34" name="permission[]" {{ ($permissions_array->contains('34')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_delete" type="checkbox" value="35" name="permission[]" {{ ($permissions_array->contains('35')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                          </tr>
                            <tr  class="tr_permition">
                            <td></td>

                            <td>{{__('frontend.court_type')}}</td>
                            <td>
                           <label class="m-checkbox m-checkbox--brand"><input class="permition_view" type="checkbox" value="36" name="permission[]" {{ ($permissions_array->contains('36')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                           </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_add" type="checkbox" value="37" name="permission[]" {{ ($permissions_array->contains('37')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input  class="permition_edit" type="checkbox" value="38" name="permission[]" {{ ($permissions_array->contains('38')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_delete" type="checkbox" value="39" name="permission[]" {{ ($permissions_array->contains('39')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                          </tr>
                            <tr  class="tr_permition">
                            <td></td>

                            <td>{{__('frontend.court')}}</td>
                            <td>
                           <label class="m-checkbox m-checkbox--brand"><input class="permition_view" type="checkbox" value="40" name="permission[]" {{ ($permissions_array->contains('40')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                           </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_add" type="checkbox" value="41" name="permission[]" {{ ($permissions_array->contains('41')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input  class="permition_edit" type="checkbox" value="42" name="permission[]" {{ ($permissions_array->contains('42')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_delete" type="checkbox" value="43" name="permission[]" {{ ($permissions_array->contains('43')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                          </tr>
                            <tr  class="tr_permition">
                            <td></td>

                            <td>{{__('frontend.case_status')}}</td>
                            <td>
                           <label class="m-checkbox m-checkbox--brand"><input class="permition_view" type="checkbox" value="44" name="permission[]" {{ ($permissions_array->contains('44')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                           </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_add" type="checkbox" value="45" name="permission[]" {{ ($permissions_array->contains('45')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input  class="permition_edit" type="checkbox" value="46" name="permission[]" {{ ($permissions_array->contains('46')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_delete" type="checkbox" value="47" name="permission[]" {{ ($permissions_array->contains('47')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                          </tr>
                            <tr  class="tr_permition">
                            <td></td>

                            <td>{{__('frontend.judge')}}</td>
                            <td>
                           <label class="m-checkbox m-checkbox--brand"><input class="permition_view" type="checkbox" value="48" name="permission[]" {{ ($permissions_array->contains('48')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                           </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_add" type="checkbox" value="49" name="permission[]" {{ ($permissions_array->contains('49')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input  class="permition_edit" type="checkbox" value="50" name="permission[]" {{ ($permissions_array->contains('50')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_delete" type="checkbox" value="51" name="permission[]" {{ ($permissions_array->contains('51')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                          </tr>
                            <tr  class="tr_permition">
                            <td></td>

                            <td>{{__('frontend.tax')}}</td>
                            <td>
                           <label class="m-checkbox m-checkbox--brand"><input class="permition_view" type="checkbox" value="52" name="permission[]" {{ ($permissions_array->contains('52')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                           </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_add" type="checkbox" value="53" name="permission[]" {{ ($permissions_array->contains('53')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input  class="permition_edit" type="checkbox" value="54" name="permission[]" {{ ($permissions_array->contains('54')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_delete" type="checkbox" value="55" name="permission[]" {{ ($permissions_array->contains('55')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                          </tr>



                            <tr>
                            <td></td>

                            <td>{{__('frontend.general_setting')}}</td>
                            <td>
                              -
                           </td>
                            <td>
                              -
                            </td>
                            <td>
                              <label class="m-checkbox m-checkbox--brand"><input class="permition_edit" type="checkbox" value="58" name="permission[]" {{ ($permissions_array->contains('58')) ? 'checked' : '' }}><div class="m-form__heading-title"></div><span></span></label>
                            </td>
                            <td>
                             -
                            </td>
                          </tr>







                        </tbody>
                      </table>



                  </div>

                </div>
                   <div class="form-group pull-right">
                        <div class="col-md-12 col-sm-6 col-xs-12">
                          <a href="{{ route('role.index')  }}" class="btn btn-danger">{{__('frontend.cancel')}}</a>

                          <button type="submit" class="btn btn-success"><i class="fa fa-save" id="show_loader"></i>&nbsp;{{__('frontend.save')}}</button>
                        </div>
                  </div>
                </form>
              </div>
            </div>




</div>
@endsection

@push('js')
    <script src="{{asset('assets/js/role/permition.js')}}"></script>


@endpush
