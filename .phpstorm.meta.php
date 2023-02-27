<?php

namespace PHPSTORM_META {
    override(
        sql_injection_subst(),
        map([
            '{{' => "tbl_",
            '}}' => "",
        ])
    );
}
