<?php
/**
 * FAQ Accordion Section (Omara-inspired minimal)
 */
$faqs = [
    [
        'q' => 'What is Trehan Iris Broadway Sector 85 Gurgaon?',
        'a' => 'Trehan Iris Broadway is a premium commercial development by Trehan Group located in Sector 85, Gurgaon. It offers high-end retail spaces, office spaces, and entertainment zones designed for maximum footfall and ROI.'
    ],
    [
        'q' => 'What is the RERA registration number for Trehan Iris Broadway?',
        'a' => 'Trehan Iris Broadway is RERA registered with Registration No. ' . PROPERTY_RERA . '. You can verify this on the Haryana RERA website for complete transparency.'
    ],
    [
        'q' => 'What types of commercial spaces are available?',
        'a' => 'The project offers a variety of commercial spaces including retail shops, food courts, office spaces, and entertainment zones. Unit sizes range from compact retail outlets to large format stores, catering to different investment budgets.'
    ],
    [
        'q' => 'What is the price range for Trehan Iris Broadway?',
        'a' => 'Prices start from ' . PROPERTY_PRICE_START . ' onwards depending on the unit size, floor, and type of commercial space. Flexible payment plans are available. Contact us for the latest price list and exclusive offers.'
    ],
    [
        'q' => 'What is the location advantage of Sector 85, Gurgaon?',
        'a' => 'Sector 85 enjoys excellent connectivity via Dwarka Expressway and NH-8. It is surrounded by premium residential sectors with a population of 50,000+ families, ensuring high footfall for commercial establishments. The area is rapidly developing as a commercial hub.'
    ],
    [
        'q' => 'What are the payment plans available?',
        'a' => 'Trehan Group offers flexible payment plans including construction-linked plans and down payment plans with attractive discounts. Bank loan facilities are available from all major banks. Contact us for customized payment options.'
    ],
    [
        'q' => 'Is Trehan Iris Broadway a good investment?',
        'a' => 'Yes, with its strategic location on Dwarka Expressway corridor, RERA registration, reputed developer (Trehan Group with 25+ years experience), and growing demand for commercial spaces in Gurgaon, it offers strong ROI potential and rental income opportunities.'
    ],
    [
        'q' => 'What amenities does Trehan Iris Broadway offer?',
        'a' => 'The project features modern amenities including multi-level parking, escalators and elevators, central air conditioning, 24/7 security with CCTV, fire safety systems, power backup, landscaped areas, and dedicated loading/unloading zones.'
    ],
];
?>
<section class="section section-alt" id="faq">
    <div class="container">
        <span class="label-sm" style="text-align:center;display:block;">Trehan Iris Broadway FAQ</span>
        <h2 class="section-title">Frequently Asked Questions About <em><?= PROPERTY_NAME ?></em></h2>
        <p class="section-subtitle">Answers to common queries about commercial investment in <?= PROPERTY_LOCATION ?></p>

        <div class="faq-list">
            <?php foreach ($faqs as $i => $faq): ?>
            <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                <button class="faq-question" aria-expanded="false" aria-controls="faq-answer-<?= $i ?>" itemprop="name">
                    <?= $faq['q'] ?>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer" id="faq-answer-<?= $i ?>" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <p itemprop="text"><?= $faq['a'] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
