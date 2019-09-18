<?php

namespace Charlielangridge\SETSCouponGenerator;

use Laravel\Nova\ResourceTool;

class SETSCouponGenerator extends ResourceTool
{
    /**
     * Get the displayable name of the resource tool.
     *
     * @return string
     */
    public function name()
    {
        return 'Coupon Generator';
    }

    /**
     * Get the component name for the resource tool.
     *
     * @return string
     */
    public function component()
    {
        return 'sets-coupon-generator';
    }
}
