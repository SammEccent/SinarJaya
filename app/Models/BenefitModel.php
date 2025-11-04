<?php

class BenefitModel
{
    private $benefits = [
        [
            'title' => 'Fast Booking',
            'description' => 'Quick and seamless ticket reservation process',
            'icon' => '<svg viewBox="0 0 24 24" fill="none"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2"/></svg>'
        ],
        [
            'title' => 'Reward Points',
            'description' => 'Earn points with every booking',
            'icon' => '<svg viewBox="0 0 24 24" fill="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke="currentColor" stroke-width="2"/></svg>'
        ],
        [
            'title' => 'Special Discounts',
            'description' => 'Exclusive deals for premium members',
            'icon' => '<svg viewBox="0 0 24 24" fill="none"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3" stroke="currentColor" stroke-width="2"/></svg>'
        ],
        [
            'title' => 'Priority Support',
            'description' => '24/7 dedicated customer service',
            'icon' => '<svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="2"/><path d="M12 8v4M12 16h.01" stroke="currentColor" stroke-width="2"/></svg>'
        ]
    ];

    public function getAllBenefits()
    {
        return $this->benefits;
    }
}
