<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class Gtmintegration extends Module
{
    public function __construct()
    {
        $this->name = 'gtmintegration';
        $this->tab = 'analytics_stats';
        $this->version = '1.5.1';
        $this->author = 'Jaymian-Lee Reinartz';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Google Tag Manager Integration');
        $this->description = $this->l('Inserts Google Tag Manager code into the header and body of your site.');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        // Assign logo to the module
        $this->icon = $this->local_path.'logo.png';
    }

    public function install()
    {
        return parent::install() && $this->registerHook('header') && $this->registerHook('displayAfterBodyOpeningTag');
    }

    public function uninstall()
    {
        return parent::uninstall() && Configuration::deleteByName('GTM_HEAD_CODE') && Configuration::deleteByName('GTM_BODY_CODE');
    }

    public function getContent()
    {
        $output = '';
        if (Tools::isSubmit('submit'.$this->name)) {
            $gtm_head_code = Tools::getValue('GTM_HEAD_CODE');
            $gtm_body_code = Tools::getValue('GTM_BODY_CODE');
            Configuration::updateValue('GTM_HEAD_CODE', base64_encode($gtm_head_code));
            Configuration::updateValue('GTM_BODY_CODE', base64_encode($gtm_body_code));
            $output .= $this->displayConfirmation($this->l('Settings updated'));
        }

        return $output.$this->renderForm();
    }

    public function renderForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                ),
                'input' => array(
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('GTM Head Code'),
                        'name' => 'GTM_HEAD_CODE',
                        'rows' => 7,
                        'cols' => 40,
                        'value' => base64_decode(Configuration::get('GTM_HEAD_CODE')),
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('GTM Body Code'),
                        'name' => 'GTM_BODY_CODE',
                        'rows' => 7,
                        'cols' => 40,
                        'value' => base64_decode(Configuration::get('GTM_BODY_CODE')),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
        $helper->allow_employee_form_lang = (int)Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG');
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submit'.$this->name;
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->fields_value['GTM_HEAD_CODE'] = base64_decode(Configuration::get('GTM_HEAD_CODE'));
        $helper->fields_value['GTM_BODY_CODE'] = base64_decode(Configuration::get('GTM_BODY_CODE'));

        return $helper->generateForm(array($fields_form));
    }

    public function hookHeader()
    {
        $gtm_head_code = base64_decode(Configuration::get('GTM_HEAD_CODE'));
        if ($gtm_head_code) {
            $this->context->smarty->assign('gtm_head_code', $gtm_head_code);
            return $this->display(__FILE__, 'views/templates/hook/header.tpl');
        }
    }

    public function hookDisplayAfterBodyOpeningTag()
    {
        $gtm_body_code = base64_decode(Configuration::get('GTM_BODY_CODE'));
        if ($gtm_body_code) {
            $this->context->smarty->assign('gtm_body_code', $gtm_body_code);
            return $this->display(__FILE__, 'views/templates/hook/body.tpl');
        }
    }
}