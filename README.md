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
            "type": string,
            "optionalFields": {
                "date1": string,
                "date2": string,
                "date3": string,
                "reason": string
            }
        }
    },
    "donor": {
        "type": string,
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
            "type": ("kind", "payment"),
            "optionalFields": {
                "form": string,
                "nature": string,
                "method": string,
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
            "type": string,
            "optionalFields": {
                "date1": string,
                "date2": string,
                "date3": string,
                "reason": string
            }
        }
    },
    "donor": {
        "type": "individual",
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
            "type": "payment",
            "optionalFields": {
                "form": string,
                "nature": string,
                "method": string,
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
            "type": string,
            "optionalFields": {
                "date1": string,
                "date2": string,
                "date3": string,
                "reason": string
            }
        }
    },
    "donor": {
        "type": "entreprise",
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
            "type": ("kind", "payment"),
            "optionalFields": {
                "method": string,
                "reason": string
            }
        }
    ]
}
```
</details>