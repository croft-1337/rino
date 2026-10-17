<?php

use App\Models\Page;

return [
    'title' =>
        'Terms of Service',

    'slug' =>
        'terms-of-service',

    'category' =>
        'legal',

    'template' =>
        'standard',

    'page_type' =>
        Page::TYPE_DOCUMENT,

    'short_description' =>
        'These Terms of Service govern the use of Rino hosting services, accounts, payments, acceptable use, and customer responsibilities.',

    'content' =>
        <<<'HTML'
<h2>1. Agreement to These Terms</h2>

<p>
    These Terms of Service govern your use of Rino's website, hosting services, accounts, and related services.
</p>

<p>
    By creating an account, purchasing a service, or using Rino services, you agree to these Terms.
</p>

<h2>2. Accounts</h2>

<p>
    You are responsible for maintaining the security of your account credentials and for all activity performed through your account.
</p>

<p>
    You must provide accurate information when creating or maintaining an account and must promptly update information when necessary.
</p>

<h2>3. Services</h2>

<p>
    Rino may provide web hosting, game hosting, virtual private servers, bot hosting, and other infrastructure or digital services.
</p>

<p>
    Service specifications, limits, features, and pricing may vary by plan.
</p>

<h2>4. Payments</h2>

<p>
    Services must be paid according to the billing cycle selected at checkout.
</p>

<p>
    Prices may be displayed in multiple currencies for convenience. Final billing and settlement may be handled by the applicable payment provider.
</p>

<p>
    Customers are responsible for applicable taxes, fees, or charges associated with their purchase where required.
</p>

<h2>5. Renewals</h2>

<p>
    Recurring services may renew automatically where automatic renewal is enabled.
</p>

<p>
    Customers are responsible for maintaining valid payment information and managing renewal preferences.
</p>

<h2>6. Suspension and Termination</h2>

<p>
    Rino may suspend or terminate a service where necessary due to:
</p>

<ul>
    <li>Non-payment</li>
    <li>Abusive or prohibited activity</li>
    <li>Security threats</li>
    <li>Violation of these Terms</li>
    <li>Legal or regulatory requirements</li>
    <li>Activities that materially affect other customers or infrastructure</li>
</ul>

<h2>7. Acceptable Use</h2>

<p>
    Customers must not use Rino services for unlawful, abusive, harmful, fraudulent, or unauthorized activities.
</p>

<p>
    Prohibited activities may include:
</p>

<ul>
    <li>Malware distribution</li>
    <li>Unauthorized access or exploitation</li>
    <li>Phishing or fraud</li>
    <li>Spam or abusive messaging</li>
    <li>Denial-of-service attacks</li>
    <li>Distribution of unlawful content</li>
    <li>Activities that intentionally disrupt network or service availability</li>
</ul>

<h2>8. Customer Content</h2>

<p>
    Customers retain responsibility for content, files, applications, software, and data placed on their services.
</p>

<p>
    Customers must ensure that their content and usage comply with applicable laws and these Terms.
</p>

<h2>9. Backups</h2>

<p>
    Unless a service specifically includes managed backups, customers are responsible for maintaining their own backups of important data.
</p>

<p>
    Backup availability or retention is not guaranteed unless specifically stated as part of the purchased service.
</p>

<h2>10. Resource Usage</h2>

<p>
    Services are subject to the resource limits associated with the selected plan.
</p>

<p>
    Excessive or abusive resource usage that negatively affects infrastructure or other customers may result in restrictions, suspension, or required plan changes.
</p>

<h2>11. Service Availability</h2>

<p>
    Rino aims to provide reliable service but does not guarantee uninterrupted or error-free availability unless a specific Service Level Agreement states otherwise.
</p>

<p>
    Services may be temporarily unavailable due to maintenance, infrastructure issues, security events, upstream provider issues, or circumstances beyond our reasonable control.
</p>

<h2>12. Changes to Services</h2>

<p>
    We may modify service features, infrastructure, limits, or pricing where reasonably necessary.
</p>

<p>
    Material changes affecting existing customers may be communicated where appropriate.
</p>

<h2>13. Refunds</h2>

<p>
    Refund eligibility is governed by the applicable refund policy, product terms, and payment circumstances.
</p>

<h2>14. Third-Party Services</h2>

<p>
    Some Rino services may rely on third-party infrastructure, software, payment processors, networks, or other providers.
</p>

<p>
    We are not responsible for failures caused solely by third-party services outside our reasonable control.
</p>

<h2>15. Limitation of Liability</h2>

<p>
    To the maximum extent permitted by applicable law, Rino is not liable for indirect, incidental, special, consequential, or punitive damages arising from the use or inability to use our services.
</p>

<p>
    Customers are responsible for maintaining appropriate backups, security measures, and operational safeguards for their own applications and data.
</p>

<h2>16. Indemnification</h2>

<p>
    You agree to be responsible for claims, losses, or liabilities arising from your misuse of the services, violation of these Terms, or infringement of third-party rights.
</p>

<h2>17. Changes to These Terms</h2>

<p>
    Rino may update these Terms from time to time. Updated Terms will be published on this page.
</p>

<p>
    Continued use of services after updated Terms become effective may constitute acceptance of the revised Terms where permitted by law.
</p>

<h2>18. Contact</h2>

<p>
    Questions about these Terms may be submitted through the contact details provided on the Rino website.
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
        110,

    'published' =>
        true,

    'system_page' =>
        false,
];