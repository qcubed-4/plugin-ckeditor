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

/**
 * Class SampleForm2
 *
 * This example demonstrates how to call an initialization function to customize the ck editor
 */

class SampleForm2 extends Form
{
    protected Q\Plugin\CKEditor $txtEditor;
    protected Button $btnSubmit;
    protected Panel $pnlResult;

    protected function formCreate(): void
    {
        $this->txtEditor = new Qp\CKEditor($this);
        $this->txtEditor->Text = '<b>Something</b> to start with.';
        $this->txtEditor->Configuration = 'ckConfig';
        $this->txtEditor->Rows = 15;

        $this->btnSubmit = new Button($this);
        $this->btnSubmit->Text = "Submit";
        $this->btnSubmit->PrimaryButton = true;
        $this->btnSubmit->AddAction(new Click(), new Ajax('submit_click'));

        $this->pnlResult = new Panel($this);
        $this->pnlResult->HtmlEntities = true;
    }

    protected function submit_click(string $strFormId, string $strControlId, string $param): void
    {
        $this->pnlResult->Text = $this->txtEditor->Text;
    }
}
SampleForm2::Run('SampleForm2');
