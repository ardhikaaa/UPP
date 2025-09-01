# TODO: Implement Guru Field Dependency on Unit Selection

## Completed Tasks
- [x] Add getGuru method to KunjunganController to fetch gurus by unit
- [x] Update routes/web.php to include /get-guru/{unit_id} route
- [x] Disable guru select fields in both add and edit modals
- [x] Update JavaScript to load gurus when unit is selected in add modal
- [x] Update JavaScript to load gurus when unit is selected in edit modal
- [x] Update edit button handler to load gurus based on existing unit

## Remaining Tasks
- [ ] Test the form functionality:
  - Open the kunjungan_uks page
  - Try to select guru without selecting unit (should be disabled)
  - Select unit, verify guru field becomes enabled and populated with gurus from that unit
  - Test edit modal similarly
- [ ] Run Laravel server if not running: `php artisan serve`
- [ ] Check browser console for any JavaScript errors
- [ ] Verify that form submission works with the new guru selection
