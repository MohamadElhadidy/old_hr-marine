$.validator.addMethod('validPassword',
    function(value, element , param) {
        if (value != '') {
            if(value.match(/.*[a-z]+.*/i) == null){
                return false;
            }
            if(value.match(/.*\d+.*/) == null){
                return false;
            }
        }
        return true;
    },
    'يجب على كلمة المرور ان يكون فيها حرف واحد او رقم واحد على الاقل'
);
/*
$.validator.addMethod('validName',
    function(value, element , param) {
        if (value != '') {
        //    if(value.match(/.*[a-z]+.*///i) == null){
             //   return false;
        //    }
//        }
      //  return true;
//    },
//    'يجب على  الاسم ان يتكون فيها حرف واحد   على الاقل'
//);
