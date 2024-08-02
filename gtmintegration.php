<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class GtmIntegration extends Module
{
    public function __construct()
    {
        $this->name = 'gtmintegration';
        $this->tab = 'analytics_stats';
        $this->version = '1.0.0';
        $this->author = 'Jaymian-Lee Reinartz';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('GTM Integration');
        $this->description = $this->l('Eenvoudige integratie van Google Tag Manager.');

        $this->ps_versions_compliancy = array('min' => '8.0', 'max' => _PS_VERSION_);
    }

    public function install()
    {
        return parent::install() && 
               $this->registerHook('displayHeader') && 
               $this->registerHook('displayFooter') && 
               Configuration::updateValue('GTM_HEAD_CODE', '') &&
               Configuration::updateValue('GTM_BODY_CODE', '');
    }

    public function uninstall()
    {
        return parent::uninstall() && 
               Configuration::deleteByName('GTM_HEAD_CODE') &&
               Configuration::deleteByName('GTM_BODY_CODE');
    }

    public function getContent()
    {
        $output = '';
        if (Tools::isSubmit('submitGtmIntegration')) {
            $gtm_head_code = Tools::getValue('GTM_HEAD_CODE');
            $gtm_body_code = Tools::getValue('GTM_BODY_CODE');

            Configuration::updateValue('GTM_HEAD_CODE', $gtm_head_code);
            Configuration::updateValue('GTM_BODY_CODE', $gtm_body_code);

            $output .= $this->displayConfirmation($this->l('Instellingen bijgewerkt.'));
        }

        return $output . $this->renderForm();
    }

    protected function renderForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('GTM Settings'),
                ),
                'input' => array(
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('GTM Head Code'),
                        'name' => 'GTM_HEAD_CODE',
                        'cols' => 60,
                        'rows' => 5,
                        'required' => true,
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('GTM Body Code'),
                        'name' => 'GTM_BODY_CODE',
                        'cols' => 60,
                        'rows' => 5,
                        'required' => true,
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'class' => 'btn btn-default pull-right',
                ),
            ),
        );

        $helper = new HelperForm();
        $helper->submit_action = 'submitGtmIntegration';
        $helper->fields_value['GTM_HEAD_CODE'] = Configuration::get('GTM_HEAD_CODE');
        $helper->fields_value['GTM_BODY_CODE'] = Configuration::get('GTM_BODY_CODE');

        return $helper->generateForm(array($fields_form));
    }

    public function hookDisplayHeader()
    {
        $this->context->smarty->assign('gtm_head_code', Configuration::get('GTM_HEAD_CODE'));
        return $this->display(__FILE__, 'views/templates/hook/header.tpl');
    }

    public function hookDisplayFooter()
    {
        $this->context->smarty->assign('gtm_body_code', Configuration::get('GTM_BODY_CODE'));
        return $this->display(__FILE__, 'views/templates/hook/footer.tpl');
    }
}
