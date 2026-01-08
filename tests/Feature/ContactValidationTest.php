<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

// Since I don't have permission to create a new database
// I'm using the existing database to run the tests
// That means after the tests are run, the table will be empty again
class ContactValidationTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create([
            'name' => 'admin',
            'password' => bcrypt('123456'),
        ]);
    }

    // ==================== STORE VALIDATION TESTS ====================

    /** @test */
    public function store_requires_name_field(): void
    {
        $response = $this->actingAs($this->user)->post(route('contacts.store'), [
            'email' => 'test@example.com',
            'contact' => '123456789',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function store_requires_name_to_be_at_least_5_characters(): void
    {
        $response = $this->actingAs($this->user)->post(route('contacts.store'), [
            'name' => 'Test', // Only 4 characters
            'email' => 'test@example.com',
            'contact' => '123456789',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function store_requires_name_to_be_at_most_100_characters(): void
    {
        $response = $this->actingAs($this->user)->post(route('contacts.store'), [
            'name' => str_repeat('a', 101), // 101 characters
            'email' => 'test@example.com',
            'contact' => '123456789',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function store_requires_email_field(): void
    {
        $response = $this->actingAs($this->user)->post(route('contacts.store'), [
            'name' => 'Valid Name',
            'contact' => '123456789',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function store_requires_valid_email_format(): void
    {
        $response = $this->actingAs($this->user)->post(route('contacts.store'), [
            'name' => 'Valid Name',
            'email' => 'invalid-email',
            'contact' => '123456789',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function store_requires_unique_email(): void
    {
        Contact::factory()->create(['email' => 'existing@example.com']);

        $response = $this->actingAs($this->user)->post(route('contacts.store'), [
            'name' => 'Valid Name',
            'email' => 'existing@example.com',
            'contact' => '123456789',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function store_requires_contact_field(): void
    {
        $response = $this->actingAs($this->user)->post(route('contacts.store'), [
            'name' => 'Valid Name',
            'email' => 'test@example.com',
        ]);

        $response->assertSessionHasErrors('contact');
    }

    /** @test */
    public function store_requires_contact_to_be_exactly_9_digits(): void
    {
        // Test with less than 9 digits
        $response = $this->actingAs($this->user)->post(route('contacts.store'), [
            'name' => 'Valid Name',
            'email' => 'test@example.com',
            'contact' => '12345678', // 8 digits
        ]);

        $response->assertSessionHasErrors('contact');

        // Test with more than 9 digits
        $response = $this->actingAs($this->user)->post(route('contacts.store'), [
            'name' => 'Valid Name',
            'email' => 'test2@example.com',
            'contact' => '1234567890', // 10 digits
        ]);

        $response->assertSessionHasErrors('contact');
    }

    /** @test */
    public function store_requires_contact_to_contain_only_digits(): void
    {
        $response = $this->actingAs($this->user)->post(route('contacts.store'), [
            'name' => 'Valid Name',
            'email' => 'test@example.com',
            'contact' => '12345678a', // Contains a letter
        ]);

        $response->assertSessionHasErrors('contact');
    }

    /** @test */
    public function store_requires_unique_contact(): void
    {
        Contact::factory()->create(['contact' => '123456789']);

        $response = $this->actingAs($this->user)->post(route('contacts.store'), [
            'name' => 'Valid Name',
            'email' => 'test@example.com',
            'contact' => '123456789',
        ]);

        $response->assertSessionHasErrors('contact');
    }

    /** @test */
    public function store_creates_contact_with_valid_data(): void
    {
        $response = $this->actingAs($this->user)->post(route('contacts.store'), [
            'name' => 'Valid Name Test',
            'email' => 'valid@example.com',
            'contact' => '123456789',
        ]);

        $response->assertRedirect(route('contacts.index'));
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('contacts', [
            'name' => 'Valid Name Test',
            'email' => 'valid@example.com',
            'contact' => '123456789',
        ]);
    }

    // ==================== UPDATE VALIDATION TESTS ====================

    /** @test */
    public function update_requires_name_field(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->actingAs($this->user)->put(route('contacts.update', $contact), [
            'email' => 'test@example.com',
            'contact' => '987654321',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function update_requires_name_to_be_at_least_5_characters(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->actingAs($this->user)->put(route('contacts.update', $contact), [
            'name' => 'Test', // Only 4 characters
            'email' => 'test@example.com',
            'contact' => '987654321',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function update_requires_name_to_be_at_most_100_characters(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->actingAs($this->user)->put(route('contacts.update', $contact), [
            'name' => str_repeat('a', 101), // 101 characters
            'email' => 'test@example.com',
            'contact' => '987654321',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function update_requires_email_field(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->actingAs($this->user)->put(route('contacts.update', $contact), [
            'name' => 'Valid Name',
            'contact' => '987654321',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function update_requires_valid_email_format(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->actingAs($this->user)->put(route('contacts.update', $contact), [
            'name' => 'Valid Name',
            'email' => 'invalid-email',
            'contact' => '987654321',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function update_allows_same_email_for_same_contact(): void
    {
        $contact = Contact::factory()->create(['email' => 'same@example.com']);

        $response = $this->actingAs($this->user)->put(route('contacts.update', $contact), [
            'name' => 'Updated Name',
            'email' => 'same@example.com', // Same email as before
            'contact' => $contact->contact,
        ]);

        $response->assertSessionDoesntHaveErrors('email');
        $response->assertRedirect(route('contacts.show', $contact));
    }

    /** @test */
    public function update_requires_unique_email_when_different(): void
    {
        $contact1 = Contact::factory()->create(['email' => 'existing@example.com']);
        $contact2 = Contact::factory()->create();

        $response = $this->actingAs($this->user)->put(route('contacts.update', $contact2), [
            'name' => 'Valid Name',
            'email' => 'existing@example.com', // Email belongs to contact1
            'contact' => '987654321',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function update_requires_contact_field(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->actingAs($this->user)->put(route('contacts.update', $contact), [
            'name' => 'Valid Name',
            'email' => 'test@example.com',
        ]);

        $response->assertSessionHasErrors('contact');
    }

    /** @test */
    public function update_requires_contact_to_be_exactly_9_digits(): void
    {
        $contact = Contact::factory()->create();

        // Test with less than 9 digits
        $response = $this->actingAs($this->user)->put(route('contacts.update', $contact), [
            'name' => 'Valid Name',
            'email' => 'test@example.com',
            'contact' => '12345678', // 8 digits
        ]);

        $response->assertSessionHasErrors('contact');

        // Test with more than 9 digits
        $response = $this->actingAs($this->user)->put(route('contacts.update', $contact), [
            'name' => 'Valid Name',
            'email' => 'test2@example.com',
            'contact' => '1234567890', // 10 digits
        ]);

        $response->assertSessionHasErrors('contact');
    }

    /** @test */
    public function update_requires_contact_to_contain_only_digits(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->actingAs($this->user)->put(route('contacts.update', $contact), [
            'name' => 'Valid Name',
            'email' => 'test@example.com',
            'contact' => '12345678a', // Contains a letter
        ]);

        $response->assertSessionHasErrors('contact');
    }

    /** @test */
    public function update_allows_same_contact_for_same_record(): void
    {
        $contact = Contact::factory()->create(['contact' => '123456789']);

        $response = $this->actingAs($this->user)->put(route('contacts.update', $contact), [
            'name' => 'Updated Name',
            'email' => $contact->email,
            'contact' => '123456789', // Same contact as before
        ]);

        $response->assertSessionDoesntHaveErrors('contact');
        $response->assertRedirect(route('contacts.show', $contact));
    }

    /** @test */
    public function update_requires_unique_contact_when_different(): void
    {
        $contact1 = Contact::factory()->create(['contact' => '123456789']);
        $contact2 = Contact::factory()->create();

        $response = $this->actingAs($this->user)->put(route('contacts.update', $contact2), [
            'name' => 'Valid Name',
            'email' => 'test@example.com',
            'contact' => '123456789', // Contact belongs to contact1
        ]);

        $response->assertSessionHasErrors('contact');
    }

    /** @test */
    public function update_modifies_contact_with_valid_data(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->actingAs($this->user)->put(route('contacts.update', $contact), [
            'name' => 'Updated Name Test',
            'email' => 'updated@example.com',
            'contact' => '999888777',
        ]);

        $response->assertRedirect(route('contacts.show', $contact));
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'name' => 'Updated Name Test',
            'email' => 'updated@example.com',
            'contact' => '999888777',
        ]);
    }

    // ==================== AUTHENTICATION TESTS ====================

    /** @test */
    public function guest_can_view_contacts_list(): void
    {
        Contact::factory()->count(3)->create();

        $response = $this->get(route('contacts.index'));

        $response->assertStatus(200);
        $response->assertViewIs('contacts.index');
    }

    /** @test */
    public function guest_can_view_single_contact(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->actingAs($this->user)->get(route('contacts.show', $contact));

        $response->assertStatus(200);
        $response->assertViewIs('contacts.show');
    }

    /** @test */
    public function guest_cannot_access_create_form(): void
    {
        $response = $this->get(route('contacts.create'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function guest_cannot_store_contact(): void
    {
        $response = $this->post(route('contacts.store'), [
            'name' => 'Valid Name',
            'email' => 'test@example.com',
            'contact' => '123456789',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('contacts', ['email' => 'test@example.com']);
    }

    /** @test */
    public function guest_cannot_access_edit_form(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->get(route('contacts.edit', $contact));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function guest_cannot_update_contact(): void
    {
        $contact = Contact::factory()->create(['name' => 'Original Name']);

        $response = $this->put(route('contacts.update', $contact), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'contact' => '123456789',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('contacts', ['name' => 'Original Name']);
    }

    /** @test */
    public function guest_cannot_delete_contact(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->delete(route('contacts.destroy', $contact));

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('contacts', ['id' => $contact->id]);
    }

    /** @test */
    public function authenticated_user_can_access_create_form(): void
    {
        $response = $this->actingAs($this->user)->get(route('contacts.create'));

        $response->assertStatus(200);
        $response->assertViewIs('contacts.create');
    }

    /** @test */
    public function authenticated_user_can_access_edit_form(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->actingAs($this->user)->get(route('contacts.edit', $contact));

        $response->assertStatus(200);
        $response->assertViewIs('contacts.edit');
    }

    /** @test */
    public function authenticated_user_can_delete_contact(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->actingAs($this->user)->delete(route('contacts.destroy', $contact));

        $response->assertRedirect(route('contacts.index'));
        $this->assertSoftDeleted('contacts', ['id' => $contact->id]);
    }
}

