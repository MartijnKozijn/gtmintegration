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
               Configuration::updateValue('GTM_CONTAINER_ID', '');
    }

    public function uninstall()
    {
        return parent::uninstall() && Configuration::deleteByName('GTM_CONTAINER_ID');
    }

    public function getContent()
    {
        $output = '';
        if (Tools::isSubmit('submitGtmIntegration')) {
            $gtm_id = Tools::getValue('GTM_CONTAINER_ID');
            if (empty($gtm_id) || !preg_match('/^GTM-\w+$/', $gtm_id)) {
                $output .= $this->displayError($this->l('Ongeldige GTM ID.'));
            } else {
                Configuration::updateValue('GTM_CONTAINER_ID', $gtm_id);
                $output .= $this->displayConfirmation($this->l('Instellingen bijgewerkt.'));
            }
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
                        'type' => 'text',
                        'label' => $this->l('GTM Container ID'),
                        'name' => 'GTM_CONTAINER_ID',
                        'size' => 20,
                        'required' => true
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'class' => 'btn btn-default pull-right'
                )
            ),
        );

        $helper = new HelperForm();
        $helper->submit_action = 'submitGtmIntegration';
        $helper->fields_value['GTM_CONTAINER_ID'] = Configuration::get('GTM_CONTAINER_ID');

        return $helper->generateForm(array($fields_form));
    }

    public function hookDisplayHeader()
    {
        $this->context->smarty->assign('gtm_id', Configuration::get('GTM_CONTAINER_ID'));
        return $this->display(__FILE__, 'views/templates/hook/header.tpl');
    }

    public function hookDisplayFooter()
    {
        $this->context->smarty->assign('gtm_id', Configuration::get('GTM_CONTAINER_ID'));
        return $this->display(__FILE__, 'views/templates/hook/footer.tpl');
    }
}
