<?php

class HomeController extends Controller
{
    private $benefitModel;

    public function __construct()
    {
        $this->benefitModel = $this->model('BenefitModel');
    }

    public function index()
    {
        $data = [
            'pageTitle' => 'Sinar Jaya - Premium Bus Travel',
            'benefits' => $this->benefitModel->getAllBenefits()
        ];

        $this->view('home/index', $data);
    }
}
