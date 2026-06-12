<?php

namespace Tests\Feature;

use App\Models\Place;
use App\Models\Province;
use App\Models\Review;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
    }

    public function test_admin_can_crud_province(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        // 1. Create Province
        $provinceData = [
            'id' => 'siem-reap',
            'name' => 'Siem Reap',
            'tagline' => 'Home of Angkor Wat',
            'description' => 'A wonderful historical province in Cambodia.',
            'image' => 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a',
        ];

        $response = $this->actingAs($admin)->post(route('admin.provinces.store'), $provinceData);
        $response->assertRedirect(route('admin.provinces.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('provinces', [
            'id' => 'siem-reap',
            'name' => 'Siem Reap',
        ]);

        // 2. Edit Province Form
        $response = $this->actingAs($admin)->get(route('admin.provinces.edit', 'siem-reap'));
        $response->assertStatus(200);

        // 3. Update Province
        $updateData = [
            'name' => 'Siem Reap Updated',
            'tagline' => 'Home of Angkor Wat Updated',
            'description' => 'A wonderful updated historical province.',
            'image' => 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a',
        ];
        $response = $this->actingAs($admin)->put(route('admin.provinces.update', 'siem-reap'), $updateData);
        $response->assertRedirect(route('admin.provinces.index'));
        $this->assertDatabaseHas('provinces', [
            'id' => 'siem-reap',
            'name' => 'Siem Reap Updated',
        ]);

        // 4. Delete Province
        $response = $this->actingAs($admin)->delete(route('admin.provinces.destroy', 'siem-reap'));
        $response->assertRedirect(route('admin.provinces.index'));
        $this->assertDatabaseMissing('provinces', [
            'id' => 'siem-reap',
        ]);
    }

    public function test_admin_can_crud_place(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        // Create a province first because of foreign key constraint
        $province = Province::create([
            'id' => 'siem-reap',
            'name' => 'Siem Reap',
            'tagline' => 'Home of Angkor Wat',
            'description' => 'A wonderful historical province in Cambodia.',
            'image' => 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a',
            'sections' => [],
        ]);

        // Create a tag to sync
        $tag = Tag::create(['name' => 'Culture']);

        // 1. Create Place
        $placeData = [
            'id' => 'angkor-wat',
            'name' => 'Angkor Wat',
            'province_id' => 'siem-reap',
            'tagline' => 'A beautiful temple',
            'image' => 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a',
            'location' => 'Siem Reap City',
            'best_time' => 'Sunrise',
            'entry_fee' => '$37',
            'quick_rating' => '5.0',
            'about' => 'This is the main temple of Angkor Wat.',
            'about_image' => 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a',
            'map_link' => 'https://maps.google.com',
            'tags' => [$tag->id],
        ];

        $response = $this->actingAs($admin)->post(route('admin.places.store'), $placeData);
        $response->assertRedirect(route('admin.places.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('places', [
            'id' => 'angkor-wat',
            'name' => 'Angkor Wat',
            'province_id' => 'siem-reap',
        ]);
        $this->assertDatabaseHas('place_tag', [
            'place_id' => 'angkor-wat',
            'tag_id' => $tag->id,
        ]);

        // 2. Edit Place Form
        $response = $this->actingAs($admin)->get(route('admin.places.edit', 'angkor-wat'));
        $response->assertStatus(200);

        // 3. Update Place
        $updateData = [
            'name' => 'Angkor Wat Updated',
            'province_id' => 'siem-reap',
            'tagline' => 'A beautiful temple Updated',
            'image' => 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a',
            'location' => 'Siem Reap City Updated',
            'best_time' => 'Sunset',
            'entry_fee' => 'Free',
            'quick_rating' => '4.9',
            'about' => 'This is the updated temple of Angkor Wat.',
            'about_image' => 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a',
            'map_link' => 'https://maps.google.com',
            'tags' => [], // Clear tags
        ];
        $response = $this->actingAs($admin)->put(route('admin.places.update', 'angkor-wat'), $updateData);
        $response->assertRedirect(route('admin.places.index'));
        $this->assertDatabaseHas('places', [
            'id' => 'angkor-wat',
            'name' => 'Angkor Wat Updated',
        ]);
        $this->assertDatabaseMissing('place_tag', [
            'place_id' => 'angkor-wat',
            'tag_id' => $tag->id,
        ]);

        // 4. Delete Place
        $response = $this->actingAs($admin)->delete(route('admin.places.destroy', 'angkor-wat'));
        $response->assertRedirect(route('admin.places.index'));
        $this->assertDatabaseMissing('places', [
            'id' => 'angkor-wat',
        ]);
    }

    public function test_admin_can_crud_tag(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        // 1. Create Tag
        $tagData = [
            'name' => 'Nature Adventure',
        ];

        $response = $this->actingAs($admin)->post(route('admin.tags.store'), $tagData);
        $response->assertRedirect(route('admin.tags.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('tags', [
            'name' => 'Nature Adventure',
        ]);

        $tag = Tag::where('name', 'Nature Adventure')->first();

        // 2. Edit Tag Form
        $response = $this->actingAs($admin)->get(route('admin.tags.edit', $tag->id));
        $response->assertStatus(200);

        // 3. Update Tag
        $updateData = [
            'name' => 'Nature Adventure Updated',
        ];
        $response = $this->actingAs($admin)->put(route('admin.tags.update', $tag->id), $updateData);
        $response->assertRedirect(route('admin.tags.index'));
        $this->assertDatabaseHas('tags', [
            'id' => $tag->id,
            'name' => 'Nature Adventure Updated',
        ]);

        // 4. Delete Tag
        $response = $this->actingAs($admin)->delete(route('admin.tags.destroy', $tag->id));
        $response->assertRedirect(route('admin.tags.index'));
        $this->assertDatabaseMissing('tags', [
            'id' => $tag->id,
        ]);
    }

    public function test_admin_can_moderate_reviews(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create(['is_admin' => false]);

        $province = Province::create([
            'id' => 'siem-reap',
            'name' => 'Siem Reap',
            'tagline' => 'Home of Angkor Wat',
            'description' => 'A wonderful historical province in Cambodia.',
            'image' => 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a',
            'sections' => [],
        ]);

        $place = Place::create([
            'id' => 'angkor-wat',
            'name' => 'Angkor Wat',
            'province_id' => 'siem-reap',
            'tagline' => 'A beautiful temple',
            'image' => 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a',
            'quick_info' => [],
            'about' => 'This is the main temple of Angkor Wat.',
        ]);

        $review = Review::create([
            'place_id' => $place->id,
            'user_id' => $user->id,
            'rating' => 5,
            'comment' => 'This place is absolutely stunning!',
        ]);

        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'comment' => 'This place is absolutely stunning!',
        ]);

        // Access index page
        $response = $this->actingAs($admin)->get(route('admin.reviews.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.reviews.index');

        // Delete review (moderation)
        $response = $this->actingAs($admin)->from(route('admin.reviews.index'))->delete(route('admin.reviews.destroy', $review->id));
        $response->assertRedirect(route('admin.reviews.index'));
        $this->assertDatabaseMissing('reviews', [
            'id' => $review->id,
        ]);
    }
}
