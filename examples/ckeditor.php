<?php
require('qcubed.inc.php');

use QCubed as Q;
use QCubed\Plugin as Qp;
use QCubed\Project\Control\ControlBase;
use QCubed\Project\Control\FormBase as Form;
use QCubed\Project\Control\Button;
use QCubed\Control\Panel;
use QCubed\Event\Click;
use QCubed\Action\Ajax;
use QCubed\Action\Server;
use QCubed\Js;

class SampleForm extends Form
{
    protected Q\Plugin\CKEditor $txtEditor;
    protected Button $btnSubmit;
    protected Panel $pnlResult;

    protected function formCreate(): void
    {
        $this->txtEditor = new Qp\CKEditor($this);
        $this->txtEditor->Text = '<b>Something</b> to start with.';

        $this->btnSubmit = new Button($this);
        $this->btnSubmit->Text = "Submit";
        $this->btnSubmit->AddAction(new Click(), new Ajax('submit_click'));

        $this->pnlResult = new Panel($this);
        $this->pnlResult->HtmlEntities = true;
    }

    protected function submit_click(string $strFormId, string $strControlId, string $param): void
    {
        $this->pnlResult->Text = $this->txtEditor->Text;
    }
}

SampleForm::Run('SampleForm');
