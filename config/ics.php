<?php

return [
    /*
     * Set DAY_LIGHT_SAVING to true if you are sending invite from Day Light Saving region. Else keep it false.
     */
    'DAY_LIGHT_SAVING' => env('DAY_LIGHT_SAVING', false),

    /*
     * Set DAY_LIGHT_SAVING_START_MONTH to the month number in which day light saving starts in your region.
     * For example, in USA it is 3 for March.
     */
    'DAY_LIGHT_SAVING_START_MONTH' => env('DAY_LIGHT_SAVING_START_MONTH', '03'),

    /*
     * Set DAY_LIGHT_SAVING_END_MONTH to the month number in which day light saving ends in your region.
     * For example, in USA it is 11 for November.
     */
    'DAY_LIGHT_SAVING_END_MONTH' => env('DAY_LIGHT_SAVING_END_MONTH', '10'),

    /*
     * Set DAY_LIGHT_SAVING_OFFSET to the offset in hours for day light saving.
     * For example, in USA it is 1 hour.
     */
    'DAY_LIGHT_SAVING_OFFSET' => '1 hours',
];
