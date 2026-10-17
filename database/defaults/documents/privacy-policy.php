<?php

use App\Models\Page;

return [
    'title' =>
        'Privacy Policy',

    'slug' =>
        'privacy-policy',

    'category' =>
        'legal',

    'template' =>
        'standard',

    'page_type' =>
        Page::TYPE_DOCUMENT,

    'short_description' =>
        'Learn how Rino collects, uses, stores, and protects information when you use our website and hosting services.',

    'content' =>
        <<<'HTML'
<h2>1. Introduction</h2>

<p>
    This Privacy Policy explains how Rino collects, uses, stores, and protects information when you visit our website, create an account, purchase hosting services, or otherwise interact with our services.
</p>

<p>
    By using our website or services, you acknowledge the practices described in this Privacy Policy.
</p>

<h2>2. Information We Collect</h2>

<p>
    We may collect information that you provide directly to us, including:
</p>

<ul>
    <li>Name and contact information</li>
    <li>Email address</li>
    <li>Account information</li>
    <li>Billing and transaction information</li>
    <li>Support requests and communications</li>
    <li>Information you provide when configuring or managing services</li>
</ul>

<p>
    We may also automatically collect technical information when you use our website, including:
</p>

<ul>
    <li>IP address</li>
    <li>Browser type</li>
    <li>Device information</li>
    <li>Operating system</li>
    <li>Pages visited</li>
    <li>Referral information</li>
    <li>Usage and diagnostic data</li>
</ul>

<h2>3. How We Use Information</h2>

<p>
    We may use collected information to:
</p>

<ul>
    <li>Provide and operate hosting services</li>
    <li>Create and manage customer accounts</li>
    <li>Process payments and transactions</li>
    <li>Provide customer support</li>
    <li>Maintain security and prevent abuse</li>
    <li>Monitor service performance and reliability</li>
    <li>Improve our website and services</li>
    <li>Communicate important service updates</li>
    <li>Comply with applicable legal obligations</li>
</ul>

<h2>4. Payment Information</h2>

<p>
    Payments may be processed through third-party payment providers. Rino may not directly store complete payment-card details where those details are handled by the payment provider.
</p>

<p>
    Payment providers may process information according to their own privacy policies and terms.
</p>

<h2>5. Cookies and Similar Technologies</h2>

<p>
    We may use cookies and similar technologies to maintain sessions, remember preferences, improve functionality, understand website usage, and support security features.
</p>

<p>
    You may control cookies through your browser settings, although disabling certain cookies may affect website functionality.
</p>

<h2>6. Service and Server Data</h2>

<p>
    Hosting services may process technical data required to operate your service, including server logs, IP addresses, resource usage, configuration information, and service activity.
</p>

<p>
    Customers are responsible for ensuring that content and data hosted through their services comply with applicable laws and our Terms of Service.
</p>

<h2>7. Information Sharing</h2>

<p>
    We do not sell personal information.
</p>

<p>
    We may share information with service providers where necessary to operate our business, including:
</p>

<ul>
    <li>Payment processors</li>
    <li>Infrastructure and data-center providers</li>
    <li>Email and communication providers</li>
    <li>Security and monitoring providers</li>
    <li>Analytics providers</li>
</ul>

<p>
    We may also disclose information where required by law, legal process, or to protect the rights, security, and integrity of our services and users.
</p>

<h2>8. Data Security</h2>

<p>
    We use reasonable administrative, technical, and organizational measures intended to protect information from unauthorized access, loss, misuse, alteration, or disclosure.
</p>

<p>
    No method of transmission or storage is completely secure, and we cannot guarantee absolute security.
</p>

<h2>9. Data Retention</h2>

<p>
    We retain information for as long as reasonably necessary to provide services, meet legal and accounting obligations, resolve disputes, maintain security, and enforce agreements.
</p>

<h2>10. Your Choices and Rights</h2>

<p>
    Depending on your location, you may have rights relating to your personal information, including access, correction, deletion, restriction, or objection to certain processing.
</p>

<p>
    Requests may be submitted through the contact information provided on our website.
</p>

<h2>11. Third-Party Links</h2>

<p>
    Our website may contain links to third-party websites or services. We are not responsible for the privacy practices or content of those third parties.
</p>

<h2>12. Children's Privacy</h2>

<p>
    Our services are not intended to knowingly collect personal information from children where prohibited by applicable law.
</p>

<h2>13. Changes to This Privacy Policy</h2>

<p>
    We may update this Privacy Policy from time to time. Updated versions will be published on this page and may include a revised last-updated date.
</p>

<h2>14. Contact</h2>

<p>
    If you have questions about this Privacy Policy or how information is handled, contact us using the contact details provided on the Rino website.
</p>
HTML,

    'document_layout' =>
        Page::DOCUMENT_LAYOUT_LEFT,

    'document_updated_at' =>
        null,

    'active' =>
        true,

    'show_in_header' =>
        true,

    'show_in_footer' =>
        true,

    'sort_order' =>
        100,

    'published' =>
        true,

    'system_page' =>
        false,
];