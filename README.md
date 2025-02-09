# livewire-chat-app with Laravel Reverb
## Timeline

### 31st Aug
- Created a new Laravel project #initialCommit with Breeze
- Installed broadcasting with `php artisan install:broadcasting` to enable broadcasting functionality
- Added pint configuration check [here](/pint.json)
- Integrated rector with support for Laravel-rector  
- Implemented phpstan with support for larastan with bleeding edge support
- Replaced volt with traditional livewire components

### 1st Sep
- Adjusted layouts to work with livewire full page components
- Added pest type coverage to ensure full type safety
- Removed email verification as it is not needed in our case
- Optimized tests for livewire components
- Expanded test coverage to reach 100%
- Created Room model, migration, factory, and tests
- Created Member model, migration, factory, and tests
- Created Chat model, migration, factory, and tests
- Established relationships between Room, Member, and Chat, and added tests for them

### 2nd Sep
- Moved dashboard and Profile components to pages directory
- Added Profile Attribute to User model and updated tests
- Created Chats component and added tests
- Refactored web.php to use middleware group for auth routes
- designed the sidebar and added the sidebar component
- Added tests for the sidebar component with and without rooms

### 3rd Sep
- We got our first PR [#1](https://github.com/MrPunyapal/livewire-chat-app/pull/1)

### 7th Sep
- Updated dependencies
- Added chats into navigation
- Designed Chats UI and moved it into component
- Added some tests to make sure everything is going right.

### 5th Oct
- Added a Select component
- Added a create room feature
- Added a switch room feature
- Added tests for the new features
- Some minor refactoring

### 6th Oct
- Updated dependencies
- Updated sidebar to show rooms from user
- Updated index component to room from user
- Updated tests to reflect the changes
- Some minor refactoring

### 2nd Jan 2025
- Updated to PHPStan 2.0 and Rector 2.0
- Upgraded PHPStan to level 10 (maximum)

### 2nd Feb 2025
- Merge PR [#3] from @JaiveerChavda

### 9th Feb 2025
- bump dependencies
- Fixed PHPStan version to 2.1.2 due to a type coverage issue. Will update it after this PR [#39](https://github.com/pestphp/pest-plugin-type-coverage/pull/39) is merged.
- Added Show component for chat messages
- refactored some code
- Added Index component for Rooms

More updates to come... 

