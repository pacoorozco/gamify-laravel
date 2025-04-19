## Documentation Structure

### 1. Introduction

- Overview of the application

- **gamify** is a gamification platform designed to track experience points (XP), monitor progress through badges, and
  suggest questions to earn XP and badges. The concept of a question is flexible, allowing you to embed links to tasks
  such as reading documentation, completing onboarding guides, or performing periodic tasks—limited only by your
  imagination.

- Key features

- **Experience Points (XP) Tracking**: Monitor user progress by assigning XP for completing tasks or challenges.
- **Badges System**: Reward users with badges for achieving specific milestones or completing predefined goals.
- **Levels and Progression**: Implement a leveling system to encourage continuous engagement and progression.
- **Customizable Questions**: Create and manage questions that can link to tasks such as reading documentation,
  completing onboarding guides, or performing periodic activities.
- **Admin Dashboard**: A user-friendly interface for managing users, badges, levels, and questions.
- **Event-Based Reputation Handling**: Automatically update user reputation based on specific actions or events.
- **Third-Party Integrations**: Integrate with external services for enhanced functionality (e.g., social login,
  analytics).
- **Custom Views and Themes**: Personalize the platform's appearance with custom views and themes.
- **Gamification Analytics**: Track user engagement and performance through detailed analytics and reports.
- **Mobile-Friendly Design**: Ensure accessibility and usability across devices with a responsive design.

- Requirements

- **PHP**: Version 8.2 or higher is required to run the application.
- **Composer**: Dependency manager for PHP to install required packages.
- **Database**: MySQL 5.7+ or PostgreSQL 12+ for storing application data.
- **Web Server**: Apache or Nginx configured to serve the application.
- **Operating System**: Linux, macOS, or Windows with WSL2 for development.
- **Browser**: A modern web browser (e.g., Chrome, Firefox) for accessing the application.
- **Node.js and npm**: (Optional) Required for managing JavaScript dependencies and building frontend assets.
- **Docker**: (Optional) For containerized development and deployment using Laravel Sail.

### 2. Installation

[Laravel Sail](https://laravel.com/docs/11.x/sail) is a lightweight CLI tool for managing Laravel's default Docker-based
development environment. It sets up multiple containers, including an application server and a database server, to meet
the application's requirements.

1. Clone the repository locally

    ```
    git clone https://github.com/pacoorozco/gamify-laravel.git gamify
    cd gamify
    ```

2. Copy [`.env.example`](.env.example) to `.env`.

   > **NOTE**: You don't need to touch anything from this file. It works with default settings.

3. Install PHP dependencies with:

   > **NOTE**: You don't need to install neither _PHP_ nor _Composer_, we are going to use
   a [Composer image](https://hub.docker.com/_/composer/) instead.

    ```
    docker run --rm \                  
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
    ```

4. Start all containers with the `sail` command.

    ```
    ./vendor/bin/sail up -d
    ```

5. Seed database in order to play with some data

    ```
    php artisan key:generate 
    php artisan migrate --seed
    ```

   **If you are using Sail, you should execute those commands using Sail**:

    ```
   # Running Artisan commands within Laravel Sail...
   sail artisan key:generate 
   sail artisan migrate --seed
    ```

6. Point your browser to `http://localhost`. Enjoy!

   > **NOTE**: Default credentials are `admin@domain.local/admin` or `player@domain.local/player`

### 3. Getting Started

- **Preloaded Data**: Upon installation, the platform comes with a set of default badges, users, and levels to help you
  get started quickly. These preloaded elements provide a foundation for exploring the platform's features.

- **Admin Dashboard**: The admin can use the **Admin Dashboard** to manage these elements:
    - **Badges**: Create, modify, or delete badges to reward users for specific achievements.
    - **Users**: Manage user accounts, including assigning roles and permissions.
    - **Levels**: Adjust or define levels and their XP requirements to structure user progression.

This setup allows you to customize the platform to suit your needs while providing a starting point for immediate use.

### 4. User Management

In the context of the **gamify** platform, a **User** represents an individual who interacts with the system. Users can
have different roles that define their permissions and access levels within the platform. The two primary roles are:

#### Player

- **Description**: A player is a regular user of the platform who participates in the gamification activities.
- **Responsibilities**:
    - Earn **Experience Points (XP)** by completing tasks or challenges.
    - Unlock **badges** and progress through **levels**.
    - Answer questions or perform activities suggested by the platform.
- **Access**:
    - Limited to features related to gameplay and personal progress tracking.
    - Cannot manage other users, badges, or system configurations.

#### Admin

- **Description**: An admin is a privileged user responsible for managing the platform and its content.
- **Responsibilities**:
    - Manage users (add, edit, or assign roles).
    - Create and manage **badges**, **levels**, and **questions**.
    - Configure platform settings, such as social login or custom views.
    - Monitor user activity and engagement through analytics.
- **Access**:
    - Full access to the **Admin Dashboard** and all management features.
    - Permissions to modify system configurations and oversee the platform's operation.

### 5. Gamification Features

#### 5.1. Experience Points (XP)

- **Description**: Experience Points (XP) are numerical values awarded to users for completing tasks, challenges, or
  activities within the platform.
- **Purpose**: XP tracks user progress and encourages engagement by providing measurable growth.
- **Examples**:
    - Earning 10 XP for completing a daily task.
    - Gaining 50 XP for finishing a training module.

#### 5.2. Badges

- **Description**: A badge is a visual representation of an achievement or milestone that a user earns by completing
  specific tasks or meeting predefined criteria.
- **Purpose**: Badges serve as a reward system to motivate users and recognize their accomplishments.
- **Examples**:
    - Completing a specific onboarding task.
    - Reaching a certain number of repetitions for an activity.
    - Achieving a milestone, such as answering 50 questions.

#### 5.3. Levels

- **Description**: Levels represent a user's progression within the platform, determined by the total XP they have
  accumulated.
- **Purpose**: Levels provide a sense of achievement and progression, encouraging users to stay engaged and strive for
  higher ranks.
- **Examples**:
    - Level 1: 0-100 XP.
    - Level 2: 101-500 XP.
    - Level 3: 501-1000 XP.

#### 5.4. Questions

- **Description**: Questions are challenges or tasks that users must complete to earn **Experience Points (XP)** and
  unlock **badges**. They are highly flexible and can represent a wide range of activities, from answering a quiz to
  completing tasks outside the application.

- **Purpose**: Questions serve as the core mechanism for engaging users, encouraging them to interact with the platform,
  and rewarding them for their efforts.

- **Types of Questions**:
    1. **Answer-Based Questions**: Users must provide a correct answer to a question or quiz.
    2. **Task-Based Questions**: Users must complete a specific task, such as reading documentation or performing an
       activity.
    3. **Exploration-Based Questions**: Users are required to find or interact with something outside the application,
       such as visiting a website or locating specific information.

- **Examples**:
    1. **Answer-Based**:
        - "What is the capital of France?" (Correct answer: Paris)
        - "What is the command to list all files in a Linux directory?"
    2. **Task-Based**:
        - "Complete the onboarding guide and mark it as done."
        - "Submit a pull request to the repository with a minor fix."
    3. **Exploration-Based**:
        - "Visit the company website and find the name of the CEO."
        - "Locate the latest version of the project documentation and provide the release date."

- **Customization**: Questions can be tailored to fit the specific needs of the platform, allowing admins to define the
  type, difficulty, and rewards (XP and badges) for each question.

- **Reward System**:
    - Each question can be assigned a specific XP value based on its difficulty.
    - Completing certain questions may unlock unique badges, such as "Explorer" for completing exploration-based tasks
      or "Quiz Master" for answering a series of questions correctly.

### 6. Customization

**gamify** provides extensive customization options to tailor the platform to your specific needs. From managing
gamification elements like badges, levels, and questions to modifying the application's appearance, you have full
control over the platform.

#### 6.1. Managing Badges, Levels, and Questions

- The **Admin Dashboard** allows you to manage key gamification elements:
    - **Badges**: Create, edit, and delete badges to reward users for specific achievements.
    - **Levels**: Define levels and their required XP to structure user progression.
    - **Questions**: Add, modify, or remove questions to engage users and assign XP or badges as rewards.

These features can be accessed and configured directly through the **Admin Dashboard**, providing a user-friendly
interface for customization.

#### 6.2. Customizing Application Pages

- The visual appearance of the application can be customized by modifying Blade templates located in the
  `resources/views/custom` folder.
- To customize a page:
    1. Create a new Blade template in the `resources/views/custom` folder.
    2. Follow the [Laravel Blade documentation](https://laravel.com/docs/11.x/blade) to write or modify the template.
    3. The platform will automatically use these custom templates to override the default views.

This approach allows you to personalize the platform's design and layout while leveraging the flexibility of Laravel's
Blade templating engine.
