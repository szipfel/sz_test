webre![alt text](http://webrepublic.ca/assets/logo-sm.png "Web Republic Corp")
# Steve Zipfel Sample Code - Drupal module

This is a basic drupal 7 module that pulls bands and songs from a RESTFul JSON web service
and provides a basic mechanism to vote for a bands best song.

![alt text](http://webrepublic.ca/drupal_sample_module/screenshot.png "Screen Shot of vote screen")

## Purpose:

Just sample code.

## JSON example
```json
[
    {
        "name": "ZZ Top",
        "songs": [
            "Sharp Dressed Man",
            "Legs",
            "Sleeping Bag"
        ]
    },
    {
        "name": "The Tragically Hip",
        "songs": [
            "New Orleans is Sinking",
            "The Hundredth Meridian",
            "Locked in the Trunk of a Car"
        ]
    },
    {
        "name": "P!nk",
        "songs": [
            "Raise Your Glass",
            "Get This Party Started",
            "Just Give Me a Reason"
        ]
    }
]
```
