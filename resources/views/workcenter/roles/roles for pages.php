@role(['superadministrator', 'administrator'])
@endrole
@role(['employee', 'client', 'supervisor'])
@include('workcenter.errors.404')
@endrole