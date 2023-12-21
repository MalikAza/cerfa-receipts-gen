# Cerfa Receipts Gen

## Installation
### Requirements
`php-pdftk` needs the `pdftk` bash command to be installed and working on the system.

(_See:_ [php-pdftk Requirements](https://github.com/mikehaertl/php-pdftk?tab=readme-ov-file#requirements))

## Documentation
### API Body Formats
<details>
    <summary>All possible keys</summary>

```json
{
    "receiptNumber": integer,
    "organism": {
        "name": string,
        "sirenOrRna": string,
        "address" : {
            "number": string,
            "street": string,
            "city": string,
            "postCode": string,
            "country": string
        },
        "object": string,
        "status": {
            "type": (
                "1901_LAW",
                "PUBLIC_UTILITY",
                "PUBLIC_UTILITY_MOSELLE",
                "OTHER",
                "UNIVERSITY",
                "COMPANY_FONDATION",
                "MUSEUM",
                "FOREST_MANAGE",
                "NGO",
                "ALSACE_MOSELLE",
                "DOTATION",
                "PRESS_PLURALISM",
                "ART_EDUCATION",
                "CONSULAR_EDUCATION",
                "SMB_FINANCIAL_SUPPORT",
                "ART_PRESENTATION",
                "HISTORICAL_MONUMENT",
                "CULTURAL_PROTECTION",
                "PRIVATE_RESEARCH",
                "COMPANY_SOCIAL",
                "INTERMEDIARY_ASSOCIATION",
                "WORKSHOP_SOCIAL",
                "ADAPTED_COMPANY",
                "ANR",
                "EMPLOYERS_GROUP",
                "RECOVERY_COMPANY",
                "EU_ORGANISM",
                "IT_SCIENTIFIC_RESEARCH",
                "DOCTORATE_THESIS",
                "FRANCE_REPRESENTATIVE",
                "AUDIOVISUALS",
                "MUSICAL_TRAINING",
                "APPROVED_ORGA_MANAGE"
            ),
            "optionalFields": {
                "date1": string,
                "date2": string,
                "reason": string
            }
        }
    },
    "donor": {
        "type": ("INDIVIDUAL", "COMPANY"),
        "lastName": string,
        "firstName": string,
        "name": string,
        "legalForm": string,
        "siren": string,
        "address": {
            "number": string,
            "street": string,
            "city": string,
            "postCode": string,
            "country": string
        }
    },
    "donations": [
        {
            "amount": float,
            "date": timestamp,
            "type": ("INKIND", "MONEY"),
            "optionalFields": {
                "form": (
                    "AUTHENTIC",
                    "PRIVATE",
                    "MANUAL",
                    "OTHER"
                ),
                "nature": (
                    "MONETARY",
                    "LISTED",
                    "ABANDONMENT",
                    "VOLUNTEERS",
                    "OTHER"
                ),
                "method": (
                    "CASH",
                    "BANK_CHECK",
                    "TRANSFER",
                    "OTHER"
                ),
                "cgi": {
                    "200": boolean,
                    "978": boolean
                },
                "reason": string
            }
        }
    ]
}
```
</details>
<details>
    <summary>CERFA 11580</summary>

```json
{
    "receiptNumber": integer,
    "organism": {
        "name": string,
        "sirenOrRna": string,
        "address" : {
            "number": string,
            "street": string,
            "city": string,
            "postCode": string,
            "country": string
        },
        "object": string,
        "status": {
            "type": (
                "1901_LAW",
                "PUBLIC_UTILITY",
                "PUBLIC_UTILITY_MOSELLE",
                "OTHER",
                "UNIVERSITY",
                "COMPANY_FONDATION",
                "MUSEUM",
                "FOREST_MANAGE",
                "NGO",
                "ALSACE_MOSELLE",
                "DOTATION",
                "PRESS_PLURALISM",
                "ART_EDUCATION",
                "CONSULAR_EDUCATION",
                "SMB_FINANCIAL_SUPPORT",
                "ART_PRESENTATION",
                "HISTORICAL_MONUMENT",
                "CULTURAL_PROTECTION",
                "PRIVATE_RESEARCH",
                "COMPANY_SOCIAL",
                "INTERMEDIARY_ASSOCIATION",
                "WORKSHOP_SOCIAL",
                "ADAPTED_COMPANY",
                "ANR",
                "EMPLOYERS_GROUP",
                "RECOVERY_COMPANY",
                "EU_ORGANISM"
            ),
            "optionalFields": {
                "date1": string,
                "date2": string,
                "reason": string
            }
        }
    },
    "donor": {
        "type": "INDIVIDUAL",
        "lastName": string,
        "firstName": string,
        "address": {
            "number": string,
            "street": string,
            "city": string,
            "postCode": string,
            "country": string
        }
    },
    "donations": [
        {
            "amount": float,
            "date": timestamp,
            "type": "MONEY",
            "optionalFields": {
                "form": (
                    "AUTHENTIC",
                    "PRIVATE",
                    "MANUAL",
                    "OTHER"
                ),
                "nature": (
                    "MONETARY",
                    "LISTED",
                    "ABANDONMENT",
                    "VOLUNTEERS",
                    "OTHER"
                ),
                "method": (
                    "CASH",
                    "BANK_CHECK",
                    "TRANSFER"
                ),
                "cgi": {
                    "200": boolean,
                    "978": boolean
                }
            }
        }
    ]
}
```
</details>

<details>
    <summary>CERFA 16216</summary>

```json
{
    "receiptNumber": integer,
    "organism": {
        "name": string,
        "sirenOrRna": string,
        "address" : {
            "number": string,
            "street": string,
            "city": string,
            "postCode": string,
            "country": string
        },
        "object": string,
        "status": {
            "type": (
                "1901_LAW",
                "PUBLIC_UTILITY",
                "OTHER",
                "UNIVERSITY",
                "COMPANY_FONDATION",
                "MUSEUM",
                "NGO",
                "ALSACE_MOSELLE",
                "DOTATION",
                "ART_EDUCATION",
                "CONSULAR_EDUCATION",
                "SMB_FINANCIAL_SUPPORT",
                "ART_PRESENTATION",
                "HISTORICAL_MONUMENT",
                "CULTURAL_PROTECTION",
                "EU_ORGANISM",
                "IT_SCIENTIFIC_RESEARCH",
                "DOCTORATE_THESIS",
                "FRANCE_REPRESENTATIVE",
                "AUDIOVISUALS",
                "MUSICAL_TRAINING",
                "APPROVED_ORGA_MANAGE"
            ),
            "optionalFields": {
                "date1": string,
                "date2": string,
                "reason": string
            }
        }
    },
    "donor": {
        "type": "COMPANY",
        "name": string,
        "legalForm": string,
        "siren": string,
        "address": {
            "number": string,
            "street": string,
            "city": string,
            "postCode": string,
            "country": string
        }
    },
    "donations": [
        {
            "amount": float,
            "date": timestamp,
            "type": ("INKIND", "MONEY"),
            "optionalFields": {
                "method": (
                    "CASH",
                    "BANK_CHECK",
                    "TRANSFER",
                    "OTHER"
                ),
                "reason": string
            }
        }
    ]
}
```
</details>