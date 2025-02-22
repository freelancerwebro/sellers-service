<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Contact;
use App\Repositories\Contracts\ContactsRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ContactsRepository implements ContactsRepositoryInterface
{
    public function getBySellerId(int $id): Collection
    {
        return Contact::whereSellerId($id)->get();
    }

    public function createFromCSVLine(array $csvLine, int $sellerId): Contact
    {
        $contact = Contact::firstOrNew([
            'seller_id' => $sellerId,
            'full_name' => $csvLine[8], // contact_customer_fullname
            'date' => $csvLine[7], // contact_date
        ]);
        $contact->full_name = $csvLine[8]; // contact_customer_fullname
        $contact->region = $csvLine[6]; // contact_region
        $contact->date = $csvLine[7]; // contact_date
        $contact->type = $csvLine[9]; // contact_type
        $contact->product_type_offered_id = $csvLine[10]; // contact_product_type_offered_id
        $contact->product_type_offered = $csvLine[11]; // contact_product_type_offered
        $contact->save();

        return $contact;
    }
}
