<?php
/**
 * Clearandfizzy
 *
 * NOTICE OF LICENSE
 *
 *
 * THE WORK (AS DEFINED BELOW) IS PROVIDED UNDER THE TERMS OF THIS CREATIVE
 * COMMONS PUBLIC LICENSE ("CCPL" OR "LICENSE"). THE WORK IS PROTECTED BY
 * COPYRIGHT AND/OR OTHER APPLICABLE LAW. ANY USE OF THE WORK OTHER THAN AS
 * AUTHORIZED UNDER THIS LICENSE OR COPYRIGHT LAW IS PROHIBITED.

 * BY EXERCISING ANY RIGHTS TO THE WORK PROVIDED HERE, YOU ACCEPT AND AGREE
 * TO BE BOUND BY THE TERMS OF THIS LICENSE. TO THE EXTENT THIS LICENSE MAY
 * BE CONSIDERED TO BE A CONTRACT, THE LICENSOR GRANTS YOU THE RIGHTS
 * CONTAINED HERE IN CONSIDERATION OF YOUR ACCEPTANCE OF SUCH TERMS AND
 * CONDITIONS.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * versions in the future. If you wish to customize this extension for your
 * needs please refer to http://www.clearandfizzy.com for more information.
 *
 * @category    Community
 * @package     Clearandfizzy_Reducedcheckout
 * @copyright   Copyright (c) 2013 Clearandfizzy Ltd. (http://www.clearandfizzy.com)
 * @license     http://creativecommons.org/licenses/by-nd/3.0/ Creative Commons (CC BY-ND 3.0) 
 * @author		Gareth Price <gareth@clearandfizzy.com>
 * 
 */
$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

$installer->addBlock("<h3>That's great!</h3>
<p>Thanks for making a purchase - we recommend you confirm your email address and enter a password so we can create a new account from the details you've given during your checkout.</p>
<h4>Benefits</h4>
<ul>
<ul>
<li>Make it easier for you to track your order &amp; get customer support.</li>
<li>You won't need to enter all your details again next-time you visit.</li>
</ul>
</ul>");


$installer->endSetup();