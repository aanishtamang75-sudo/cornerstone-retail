# AI Governance Appendix

## Design intent (for report and demo)

The AI feature is **intentionally low-risk**. It generates draft product descriptions using **local rule-based logic** in `DescriptionAssistantService.php`. The description is **not saved automatically**. The admin must **review and edit** the text in the form before clicking Save. A visible disclaimer states that AI-generated content requires human review.

This approach avoids sending data to public AI services, supports responsible AI requirements in the brief, and keeps behaviour predictable for marking and demonstration.

## Features chosen

1. **Help assistant (AI Option 1)** — `src/Services/HelpAssistantService.php` + `data/faq.json`
2. **Description drafting (AI Option 4)** — `src/Services/DescriptionAssistantService.php`

## Data handling

- No personal customer data is collected for AI processing.
- Product draft notes are generic merchandising text only.
- No calls to public cloud LLM APIs in this build.

## Prompt / logic approach

| Feature | Input | Processing | Output |
|---------|-------|------------|--------|
| Help | User question string | Keyword match against curated FAQ JSON | Answer + source tag |
| Description | Product name, rough notes, category | Template enrichment + keyword rules | Suggested marketing description |

## Human-in-the-loop

- Description suggestions populate an **editable** textarea.
- Alert/disclaimer: *"AI-generated content requires human review before saving or publishing."*
- On save, `ai_suggestion_log` records suggested vs accepted text via `ai.logAcceptance`.

## Limitations & mitigations

| Limitation | Mitigation |
|------------|------------|
| Help may not understand complex phrasing | Fallback message + topic list; expand FAQ |
| Descriptions may sound generic | Admin edits before publish; not auto-saved |
| No semantic search | Acceptable for assessment scope; could extend later |

## Required safety statement

> **AI-generated content requires human review before publishing.**

This appears in the product form UI, configuration (`config/app.php`), and must be stated in demos and reports.

## Team AI use statement (development)

Generative AI may have been used to assist with code structure and documentation. All team members review, test, and understand submitted work. Business logic and security controls are implemented manually and verified with test cases.
