<?php
    try
    {
        $emailAddress = 'your-emailadres@provider.dot';
        $firstName = 'Firstname';

        $externalId = md5($emailAddress);

        $contact = new \Spotler\Models\Contact();
        $contact->setChannel(\Spotler\Models\Contact::CONTACT_CHANNEL_EMAIL);
        $contact->externalId = $externalId;
        $contact->setProperty('email', $emailAddress);
        $contact->setProperty('firstName', $firstName);

        $contactRequest = new \Spotler\Models\ContactRequest();
        $contactRequest->update = true;
        $contactRequest->setContact($contact);

        $campaignTriggerRequest = new \Spotler\Models\CampaignTriggerRequest();
        $campaignTriggerRequest->externalContactId = $externalId;

        $client = new \Spotler\SpotlerClient('consumerKey', 'consumerSecret');
        if ($client->contact()->postContact($contactRequest))
        {
            if ($client->campaign()->postCampaignTrigger('encryptedTriggerId', $campaignTriggerRequest))
            {
                echo "campaign trigger fired";
                return;
            }
            echo "campaign trigger not fired";
            return;
        }
        echo "contact not created";
        return;
    }
    catch (Exception $ex)
    {
        // Some error handling here?
    }
