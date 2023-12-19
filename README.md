# Cerfa Receipts Gen

## Installation
### Requirements
`php-pdftk` needs the `pdftk` bash command to be installed and working on the system.

(_See:_ [php-pdftk Requirements](https://github.com/mikehaertl/php-pdftk?tab=readme-ov-file#requirements))

## Documentation
### API Body Formats
<details>
    <summary>CERFA 11580</summary>

```json
{
    "receiptOrder": string,
    "association": {
        "name": string,
        "sirenOrRna": string,
        "address": {
            "number": integer,
            "roadName": string,
            "postalCode": string,
            "city": string,
            "country": string
        },
        "cac": [
            string
        ]
    },
    "object": string,
    "donor": {
        "lastName": string,
        "firstName": string,
        "address": {
            "number": integer,
            "roadName": string,
            "postalCode": string,
            "city": string,
            "country": string
        }
    },
    "donation": {
        "amount": integer,
        "amountInWords": string,
        "date": timestamp,
        "formCac": [
            "authentic",
            "private",
            "manual",
            "other"
        ],
        "natureCac": [
            "numerary",
            "listedCompanies",
            "expressAbandonment",
            "volunteers",
            "others"
        ],
        "numeraryNatureCac": [
            "cash",
            "bankCheck",
            "transferDebitCard"
        ]
    },
    "cacCgi": [
        200,
        978
    ],
    "signatureDate": timestamp 
}
```
</details>

<details>
    <summary>CERFA 16216</summary>

```json
{
    "receiptOrder": string,
    "association": {
        "name": string,
        "sirenOrRna": string,
        "address": {
            "number": integer,
            "roadName": string,
            "postalCode": string,
            "city": string,
            "country": string
        },
        "cac": [
            string
        ]
    },
    "object": string,
    "entreprise": {
        "name": string,
        "legalStatus": string,
        "siren": string,
        "address": {
            "number": integer,
            "roadName": string,
            "postalCode": string,
            "city": string
        }
    },
    "donation": {
        "kindDonation": {
            "amount": integer,
            "amountInWords": string,
            "description": string
        },
        "payment": {
            "amount": integer,
            "amountInWords": string,
            "formCac": [
                "cash",
                "bankCheck",
                "transferDebitCard",
                "other"
            ]
        },
        "toOrganization": {
            "amount": integer,
            "amountInWords": string
        }
    },
    "signatureDate": timestamp
}
```