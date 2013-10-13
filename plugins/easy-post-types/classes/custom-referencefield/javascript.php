<?php
class ReferenceField_Javascript {

    public function create($parent) {
        $added  = __('The post has been added','cct');

    $var = <<< EOF
    <script language="javascript">

    if (typeof referenceField == 'undefined')
        var referenceField = {};
    else
        referenceField = referenceField||{};

    referenceField.__=function(s) {
        var msg={
            'added': '$added',
            };
        if(msg[s]){
          return msg[s];
        } else {
          if(window.console && window.console.log){
            window.console.log('Missing translation for: '+s);
          }
          return s;
        }
    };
</script>
EOF;
    echo $var;
    }
}
