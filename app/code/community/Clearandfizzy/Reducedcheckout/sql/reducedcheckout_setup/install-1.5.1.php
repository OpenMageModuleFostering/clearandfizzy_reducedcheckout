<?php 


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