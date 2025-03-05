# Export Core by Amasty
<h3>Note:  This free solution version is provided to allow you to evaluate our code quality. However, it does not include ready-made entities such as products, orders, and customers, which are essential for utilizing the import/export functionality. To execute exports, you will need to either create these entities yourself if you have the relevant skills or purchase the full solution version on our website. </h3>
<p>The export core is a part of the full Import and Export solution. Install together with the <a href="https://github.com/AmastyLtd/module-import-core" target="_blank">Import Core</a> and <a href="https://github.com/AmastyLtd/module-import-export-core" target="_blank">Import\Export Core</a> to see the full scope of data transfer features between multiple platforms This free package has the same code and architecture as the original paid <a href="https://amasty.com/import-and-export-for-magento-2.html" target="_blank">Import and Export for Magento 2</a> extension but with the core options only. The package can be used for manual data exporting. See the full scope of automatization features and ready-made entities available in the paid version <a href="https://export-extensions-m2.magento-demo.amasty.com/admin/amorderimport/profile/index/" target="_blank">in this demo</a> or <a href="https://calendly.com/yuliya-simakovich/book-a-demo" target="_blank">book a live demo</a> with the Amasty team to get a consultation in real-time.</p>


![import-and-export-premium-key-features](https://github.com/AmastyLtd/module-export-core/assets/104132415/e8194adb-954e-4bb3-9d0e-579c882e696e)


The paid version has Lite, Pro and Premium packages. <a href="https://amasty.com/import-and-export-for-magento-2.html#choose_option" target="_blank">Visit our website</a> to discover pricing plans available. A free package is a part of the Lite version of the full <a href="https://amasty.com/import-and-export-for-magento-2.html" target="_blank">Import and Export for Magento 2</a> extension, but without ready-made entities for migration.

<h2>What is this package for?</h2>
<p>Export Core is a multipurpose tool for data transferring from Magento 2. The solution has nothing in common with the native Magento import and export since it has a brand new architecture and code structure. Keep in mind that a <b>free core does not include ready-made entities</b> (e.g. Orders, Products) but the code structure lets you develop compatibility with any entity you need. </p>
<h2>Free version options included</h2>
<p>This package lets you:</p>
<ul>
<li><b>Perform manual one-time export of any entity:</b> the extension has a separate interface that lets you extract the data you need but does not include automatization options. It means that each data transfer should be configured separately.</li>
<li><b>Use 2 file formats:</b> CSV and XML formats supported in a free version.</li>
<li><b>Use 2 sources for data output:</b> download export files from the admin panel or use local directories.</li>
<li><b>File configuration:</b> add header row, customize entity keys and set suitable field names to meet the requirements of 3rd-party systems.  </li>
<li><b>Automatically modify the values:</b> use text, numeric, date or custom modifiers to change the values in the final export file (round prices, capitalize product names, etc.).  </li>
<li><b>Filter data:</b> export only relevant data by applying multiple filtering parameters. </li>
<li><b>Adjust performance settings:</b> limit the number of parallel processes according to your server capabilities. </li>
</ul>
<h2>Installation</h2>
<p>To install the package, run the following commands:</p>
<code>composer require amasty/module-export-core</code><br>
<code>php bin/magento setup:upgrade</code><br>
<code>php bin/magento setup:di:compile </code><br>
<code>php bin/magento setup:static-content:deploy (your locale)</code><br>
<br>
<p>See more details in the <a href="https://amasty.com/docs/doku.php?id=magento_2:composer_user_guide" target="_blank">Composer User Guide</a>. </p>
<h2>Export Configuration & Flow</h2>
<p><b>To export data, you need to create the required entity or entities (e.g. products, orders, customers) first</b>. Let’s see how it works in the free version using the example of the ‘Order’ entity.</p>
<h3>Export Configuration </h3>
<p>Navigate to the <b>Export</b> tab. Here you can choose the entity to export. For instance, we can export order items.</p>

![164422769-4fa91839-3358-4341-ac5e-459955ed8cf7](https://user-images.githubusercontent.com/104132415/194511075-12eeb840-b336-4b19-a140-427e5eae0933.png)

<p>When the required entity is chosen, proceed to the configuration. </p>
<h4>Step 1. Configure your file</h4>
<p>It is possible to export files in an XML or CSV format.</p>

![164429610-8affadff-05b2-4acc-83e5-469012f4818d](https://user-images.githubusercontent.com/104132415/194511346-426656ba-92e7-4b0f-b660-97a00610b5d2.png)

<p>If you choose a CSV file, you can also add:</p>
<ul>
<li>a header row;</li>
<li>merge rows into one; </li>
<li>duplicate parent entity data;</li>
<li>set delimiters for fields and entity keys;</li>
<li>define enclosure characters. </li>
</ul>

<p>To configure file settings correctly, please explore the requirements of the platform you are going to transfer data to.</p>
<h4>Step 2. Set the file title</h4>
<p>Name your file. You can also set a regular expression to fill in the date automatically.</p>

![164425407-7ca59381-0b27-4d93-9bd3-f4e8910b8fb0](https://user-images.githubusercontent.com/104132415/194511655-a11f5512-1442-4c3f-a38b-c3f3d7522db6.png)

<h4>Step 3. Define output option </h4>

<p>When the configuration is finished, you’ll be able to download a ready file right from the interface. But, in addition to this, you can send the file to the local server. </p>

![164425732-ee116c77-8d13-46b7-9c35-4c5a182bdcf8](https://user-images.githubusercontent.com/104132415/194511814-c7e6f084-fb0f-41ee-8004-858fcd632db6.png)

<h4>Step 4. Fields adjustment</h4>
<p>Here you choose what data should be displayed in the file and how it must be arranged and named. The export file has a tree-structure logic: first, you need to choose the key entities to enable, and then select the subentities containing the details about the main one.</p> 
<p>For detailed instructions on each step check <a href="https://amasty.com/docs/doku.php?id=magento_2:import_and_export#fields_configuration" target="_blank">this guide</a>. </p>

![164426448-6b33bd09-3d2e-4154-b048-eeb6e586d39f](https://user-images.githubusercontent.com/104132415/194512104-7ff1168f-776c-4203-97b0-823b7b9ec0af.png)

<p>Start with the naming configuration. Customize entity keys that should be displayed in the columns. </p>
<ul>
  <li><b>Custom entity key</b> — set the key that should be placed before the title of the main entity columns. </li>
  <li><b>Output entity key</b> — provide custom keys to replace the default ones in the subentities-related columns. </li>
</ul>

![164426821-bc2890da-673c-454d-a577-0d05dec7134f](https://user-images.githubusercontent.com/104132415/194512243-650536dd-b960-4273-a7eb-3d1e083130a3.png)

<p>As we want to export order items, add the fields you need in the pop-up window.</p>

![164427171-6abe2349-0e7c-4827-bbfb-d9a0fe54f2c8](https://user-images.githubusercontent.com/104132415/194512339-26ff5e68-f53e-44df-aecf-59a6b6be0937.png)

<p>You can remove the fields and reorder them by using the drag-and-drop functionality. Please, keep in mind that the file reproduces the order set during the configuration.</p>

![164427571-8d47acd2-85ae-409d-9922-75f680e956f7](https://user-images.githubusercontent.com/104132415/194512477-da7ea1b7-505b-4828-ab10-e88e293218e0.png)

<p>Customize column titles for each field to match the requirement of the platform you are exporting to. </p>

![164427854-a008770b-7913-4a6f-9cd6-fb5ae90c1b8f](https://user-images.githubusercontent.com/104132415/194512578-4f05804a-50ca-4f4d-bc79-e2c0fa768335.png)

<p>Also, use modifiers to change the values if needed. You can modify texts, numbers, dates and some additional parameters. Learn more about each modifier <a href="https://amasty.com/docs/doku.php?id=magento_2:import_and_export#modify_values_in_export_files" target="_blank">in this section</a>. </p>

![164429139-ed449af1-7d2f-4521-9bc8-f73845a521b7](https://user-images.githubusercontent.com/104132415/194512741-4656d39c-58e9-4af0-8106-b88910e7267e.png)

<p>Last, choose additional entities to export, e.g. Orders / Order Tax / Shipment, etc. and configure them in the same way. </p>

![164429428-7515cd11-156c-47fb-8a97-8862e2ee5d78](https://user-images.githubusercontent.com/104132415/194512898-98651de2-cfad-4034-b2e4-589d012cf87a.png)

<h4>Step 5. Apply filtering </h4>
<p>Select the filters to sort the data that should be placed in the file. Filter by any entity and value enabled during the fields configuration. </p>

![filters](https://user-images.githubusercontent.com/104132415/194513723-de4501e5-6018-491d-9d35-d509f11b01c6.png)

<p>Once everything is configured, click the Continue button to generate the file. </p>

![164430388-354c2965-0dff-43af-8d04-600f142d6506](https://user-images.githubusercontent.com/104132415/194513842-d16d2cde-7e59-4e0d-b04b-9658911ea07c.png)

<p>Download the file. That’s it!</p>

<h2>Full Version Overview & Pricing Plans</h2>
<p>The full solution has <a href="https://amasty.com/import-and-export-for-magento-2.html#choose_option" target="_blank">3 pricing plans</a>: Lite, Pro and Premium. Unlike the free package, full versions let you import and export orders, products, customers, CMS blocks and other entities without additional development.</p> 


![import-export-tariff-plans](https://github.com/AmastyLtd/module-export-core/assets/104132415/088eb737-438a-4431-8396-205cd311159b)



<h3>Key features of each solution:</h3>
<h4>Lite</h4> 
<ul>
<li><b>Manual import/export tasks</b> (has the same interface as the free version)</li>
<li><b>3 ready-made entities:</b> order, product, customer</li>
<li><b>2 file formats:</b> CSV, XML</li>
<li><b>2 sources:</b> file upload/local directory</li>
</ul>
<h4>Pro</h4>
<ul>
<li><b>One-time manual import/export tasks</b> (has the same interface as the free version)</li>
<li><b>Additional interface</b> to automate import and export tasks using cron jobs</li>
<li><b>3 entities:</b> order, product, customer</li>
<li><b>6 file formats:</b> CSV, XML, ODS, XLSX, Template, JSON</li>
<li><b>9 file sources:</b> File Upload, FTP/SFTP, Direct URL, Google Sheets, REST API Endpoint, Dropbox, Google Drive, Email for export</li>
<li><b>Import/export history</b></li>
 </ul>
<h4>Premium </h4>
<ul>
<li><b>Fully automated data synchronization</b> of all entities using profiles</li>
<li><b>Automatic profiles execution</b></li>
<li><b>One-time manual import/export tasks</b></li>
<li><b>9 entities:</b> orders, products, customers, CMS blocks and pages, URL rewrites, EAV attributes, catalog price rules, cart price rules, search terms and synonyms </li>
<li><b>Automation using cron jobs</b></li>
<li><b>6 file formats:</b> CSV, XML, ODS, XLSX, Template, JSON</li>
<li><b>9 file sources:</b> File Upload, FTP/SFTP, Direct URL, Google Sheets, REST API Endpoint, Dropbox, Google Drive, Email for export</li>
<li><b>Import/export histories</b> and profile running logs</li>
 </ul>
<p class="text-align: center"><a href="https://amasty.com/import-and-export-for-magento-2.html">Import and Export Premium</a></p>

![import-and-export-premium-key-features](https://github.com/AmastyLtd/module-export-core/assets/104132415/a72461e2-ba4a-423b-a586-9e561dd0a871)


If you need a specific entity, but with the automation options, you can purchase the main ones separately:  
<br>
-> <a href="https://amasty.com/import-orders-for-magento-2.html" target="_blank">Import Orders</a><br>
-> <a href="https://amasty.com/export-orders-for-magento-2.html" target="_blank">Export Orders</a><br>
-> <a href="https://amasty.com/import-products-for-magento-2.html" target="_blank">Import Products</a><br>
-> <a href="https://amasty.com/export-products-for-magento-2.html" target="_blank">Export Products</a><br>
-> <a href="https://amasty.com/import-customers-for-magento-2.html" target="_blank">Import Customers</a><br>
-> <a href="https://amasty.com/export-customers-for-magento-2.html" target="_blank">Export Customers</a><br>
<h2>Troubleshooting </h2>
<p><i>Have any questions? Feel free to <a href="https://amasty.com/contacts/">contact us</a>!</i></p> 
<p><i>Want us to develop a custom integration? <a href="https://amasty.com/magento-integration-service.html">Find the details here</a>.</i></p> 

<h2>Other Amasty extensions</h2>
-> <a href="https://amasty.com/xml-google-sitemap-for-magento-2.html" target="_blank">XML Google® Sitemap for Magento 2</a><br>
-> <a href="https://amasty.com/worldline-payments-for-magento-2.html" target="_blank">Wordline Payments for Magento 2</a><br>
-> <a href="https://amasty.com/visual-merchandiser-for-magento-2.html" target="_blank">Visual Merchandiser for Magento 2</a><br>
-> <a href="https://amasty.com/url-rewrites-regenerator-for-magento-2.html" target="_blank">URL Rewrites Regenerator for Magento 2</a><br>
-> <a href="https://amasty.com/unique-product-url-for-magento-2.html" target="_blank">SEO URL Rewrite for Magento 2</a><br>
-> <a href="https://amasty.com/two-factor-authentication-for-magento-2.html" target="_blank">Two-Factor Authentication for Magento 2</a><br>
-> <a href="https://amasty.com/twitter-pixel-for-magento-2.html" target="_blank">X (Twitter) Pixel for Magento 2</a><br>
-> <a href="https://amasty.com/tik-tok-pixel-for-magento-2.html" target="_blank">TikTok Pixel for Magento 2</a><br>
-> <a href="https://amasty.com/thank-you-page-for-magento-2.html" target="_blank">Thank You Page for Magento 2</a><br>
-> <a href="https://amasty.com/subscriptions-recurring-payments-for-magento-2.html" target="_blank">Subscriptions & Recurring Payments for Magento 2</a><br>
-> <a href="https://amasty.com/store-switcher-for-magento-2.html" target="_blank">Store Switcher for Magento 2</a><br>
-> <a href="https://amasty.com/store-pickup-with-locator-for-magento-2.html" target="_blank">Store Pickup with Locator for Magento 2</a><br>
-> <a href="https://amasty.com/store-pickup-for-magento-2.html" target="_blank">Store Pickup for Magento 2</a><br>
-> <a href="https://amasty.com/store-locator-for-magento-2.html" target="_blank">Store Locator for Magento 2</a><br>
-> <a href="https://amasty.com/special-promotions.html" target="_blank">Special Promotions</a><br>
-> <a href="https://amasty.com/special-promotions-pro.html" target="_blank">Special Promotions Pro</a><br>
-> <a href="https://amasty.com/single-step-checkout.html" target="_blank">One Step Checkout</a><br>
