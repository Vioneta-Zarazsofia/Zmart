<style>
    .faq-section {
        padding: 60px 0;
    }
    .accordion-faq {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .accordion-faq-item {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 22px 24px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
        cursor: pointer;
        transition: 0.3s ease;
    }
    .accordion-faq-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 700;
        font-size: 1.3rem;
        color: #222;
    }
    .accordion-faq-body {
        display: none;
        padding-top: 16px;
        font-size: 1.1rem;
        color: #444;
        line-height: 1.75;
    }
    .accordion-faq-item.active .accordion-faq-body {
        display: block;
    }
    .arrow {
        transition: transform 0.3s ease;
    }
    .accordion-faq-item.active .arrow {
        transform: rotate(180deg);
    }
    .arrow svg {
        width: 20px;
        height: 20px;
    }
</style>
