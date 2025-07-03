<?php
/**
 * This file contains the CKEditor Class.
 */

namespace QCubed\Plugin;

use QCubed\Control\ControlBase;
use QCubed\Control\FormBase;
use QCubed\Exception\Caller;
use QCubed\Exception\InvalidCast;
use QCubed\Project\Control\TextBox;
use QCubed\Control\TextBoxBase;
use QCubed\Type;

/**
 * Class CKEditorBase: For creating a Rich text editor with CKEditor
 *
 * @package QCubed\Plugin
 *
 * @property-write string $ReadyFunction JS function to pass to the ckeditor creation instance
 * @property-write string $Configuration Configuration options to pass to the ckeditor instance
 */
class CKEditorBase extends TextBox
{
    protected $strJsReadyFunc = 'function(){}';
    protected $strConfiguration = '{}';

    public function __construct(ControlBase|FormBase $objParentObject, ?string $strControlId = null) {
        parent::__construct($objParentObject, $strControlId);
        $this->registerFiles();
        $this->strCrossScripting = TextBox::XSS_ALLOW;
        $this->strTextMode = TextBoxBase::MULTI_LINE;
    }

    protected function registerFiles(): void
    {
        $this->AddJavascriptFile(QCUBED_CKEDITOR_ASSETS_URL . "/js/CKSetup.js");
        $this->AddJavascriptFile(QCUBED_VENDOR_URL . "/ckeditor/ckeditor/ckeditor.js");
        $this->AddJavascriptFile(QCUBED_VENDOR_URL . "/ckeditor/ckeditor/adapters/jquery.js");
    }

    protected function makeJqWidget(): void
    {
        return;
    }

    public function getControlJavaScript(): string
    {
        $strFormId = $this->Form->FormId;
        $strControlId = $this->ControlId;
        $strReadyFunc = 'null';
        if ($this->strJsReadyFunc) {
            $strReadyFunc = $this->strJsReadyFunc;
        }
        $strCtrlJs = "function() {qcubed.qckeditor(this, '{$strFormId}', '{$strControlId}', {$strReadyFunc});}";
        return sprintf('jQuery("#%s").%s(%s, %s)', $this->getJqControlId(), $this->getJqSetupFunction(), $strCtrlJs, $this->strConfiguration);
    }

    public function getEndScript(): string
    {
        return  $this->getControlJavaScript() . '; ' . parent::getEndScript();
    }

    public function getJqSetupFunction(): string
    {
        return 'ckeditor';
    }

    public function __set(string $strName, mixed $mixValue): void
    {
        //$this->blnModified = true;
        switch ($strName) {
            case "ReadyFunction":
                // The name of a javascript function to call after the CKEditor instance is ready, so that you can do further initialization
                // This function will receive the formId and controlId as parameters, and "this" will be the ckeditor instance.
                try {
                    $this->strJsReadyFunc = Type::Cast($mixValue, Type::STRING);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
                break;

            case "Configuration":
                // The configuration string. Could be a name of an object, or a javascript object (sourrounded by braces {})
                try {
                    $this->strConfiguration = Type::Cast($mixValue, Type::STRING);
                    break;
                } catch (InvalidCast $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
                break;

            default:
                try {
                    parent::__set($strName, $mixValue);
                } catch (Caller $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
                break;
        }
    }
}
