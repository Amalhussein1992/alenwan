<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This migration adds performance-enhancing indexes to frequently queried columns
     * and creates composite indexes for common query patterns.
     */
    public function up(): void
    {
        // Movies table indexes
        if (Schema::hasTable('movies')) {
            Schema::table('movies', function (Blueprint $table) {
                // Single column indexes
                if (!$this->hasIndex('movies', 'movies_status_index')) {
                    $table->index('status', 'movies_status_index');
                }
                if (!$this->hasIndex('movies', 'movies_category_id_index')) {
                    $table->index('category_id', 'movies_category_id_index');
                }
                if (!$this->hasIndex('movies', 'movies_language_id_index')) {
                    $table->index('language_id', 'movies_language_id_index');
                }
                if (!$this->hasIndex('movies', 'movies_subscription_tier_index')) {
                    $table->index('subscription_tier', 'movies_subscription_tier_index');
                }
                if (!$this->hasIndex('movies', 'movies_release_year_index')) {
                    $table->index('release_year', 'movies_release_year_index');
                }

                // Composite indexes for common queries
                if (!$this->hasIndex('movies', 'movies_status_subscription_tier_index')) {
                    $table->index(['status', 'subscription_tier'], 'movies_status_subscription_tier_index');
                }
                if (!$this->hasIndex('movies', 'movies_category_status_index')) {
                    $table->index(['category_id', 'status'], 'movies_category_status_index');
                }
                if (!$this->hasIndex('movies', 'movies_views_count_index')) {
                    $table->index('views_count', 'movies_views_count_index');
                }
                if (!$this->hasIndex('movies', 'movies_rating_index')) {
                    $table->index('rating', 'movies_rating_index');
                }
                if (!$this->hasIndex('movies', 'movies_created_at_index')) {
                    $table->index('created_at', 'movies_created_at_index');
                }
            });
        }

        // Series table indexes
        if (Schema::hasTable('series')) {
            Schema::table('series', function (Blueprint $table) {
                // Single column indexes
                if (!$this->hasIndex('series', 'series_status_index')) {
                    $table->index('status', 'series_status_index');
                }
                if (!$this->hasIndex('series', 'series_category_id_index')) {
                    $table->index('category_id', 'series_category_id_index');
                }
                if (!$this->hasIndex('series', 'series_language_id_index')) {
                    $table->index('language_id', 'series_language_id_index');
                }
                if (!$this->hasIndex('series', 'series_subscription_tier_index')) {
                    $table->index('subscription_tier', 'series_subscription_tier_index');
                }

                // Composite indexes
                if (!$this->hasIndex('series', 'series_status_subscription_tier_index')) {
                    $table->index(['status', 'subscription_tier'], 'series_status_subscription_tier_index');
                }
                if (!$this->hasIndex('series', 'series_category_status_index')) {
                    $table->index(['category_id', 'status'], 'series_category_status_index');
                }
                if (!$this->hasIndex('series', 'series_views_count_index')) {
                    $table->index('views_count', 'series_views_count_index');
                }
                if (!$this->hasIndex('series', 'series_rating_index')) {
                    $table->index('rating', 'series_rating_index');
                }
            });
        }

        // Users table indexes
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                // Email index (if not already exists from migration)
                if (!$this->hasIndex('users', 'users_email_index') && !$this->hasIndex('users', 'users_email_unique')) {
                    $table->index('email', 'users_email_index');
                }

                // Status and subscription related indexes
                if (!$this->hasIndex('users', 'users_status_index')) {
                    $table->index('status', 'users_status_index');
                }
                if (!$this->hasIndex('users', 'users_subscription_tier_index')) {
                    $table->index('subscription_tier', 'users_subscription_tier_index');
                }
                if (!$this->hasIndex('users', 'users_subscription_expires_at_index')) {
                    $table->index('subscription_expires_at', 'users_subscription_expires_at_index');
                }

                // Composite index for active subscriptions
                if (!$this->hasIndex('users', 'users_subscription_status_index')) {
                    $table->index(['subscription_tier', 'subscription_expires_at'], 'users_subscription_status_index');
                }
            });
        }

        // User subscriptions table indexes
        if (Schema::hasTable('user_subscriptions')) {
            Schema::table('user_subscriptions', function (Blueprint $table) {
                if (!$this->hasIndex('user_subscriptions', 'user_subscriptions_user_id_index')) {
                    $table->index('user_id', 'user_subscriptions_user_id_index');
                }
                if (!$this->hasIndex('user_subscriptions', 'user_subscriptions_plan_id_index')) {
                    $table->index('plan_id', 'user_subscriptions_plan_id_index');
                }
                if (!$this->hasIndex('user_subscriptions', 'user_subscriptions_status_index')) {
                    $table->index('status', 'user_subscriptions_status_index');
                }
                if (!$this->hasIndex('user_subscriptions', 'user_subscriptions_ends_at_index')) {
                    $table->index('ends_at', 'user_subscriptions_ends_at_index');
                }

                // Composite indexes for common queries
                if (!$this->hasIndex('user_subscriptions', 'user_subscriptions_user_status_index')) {
                    $table->index(['user_id', 'status'], 'user_subscriptions_user_status_index');
                }
            });
        }

        // Categories table indexes
        if (Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                if (!$this->hasIndex('categories', 'categories_type_index')) {
                    $table->index('type', 'categories_type_index');
                }
                if (!$this->hasIndex('categories', 'categories_is_active_index')) {
                    $table->index('is_active', 'categories_is_active_index');
                }
                if (!$this->hasIndex('categories', 'categories_sort_order_index')) {
                    $table->index('sort_order', 'categories_sort_order_index');
                }

                // Composite index for active categories by type
                if (!$this->hasIndex('categories', 'categories_type_active_sort_index')) {
                    $table->index(['type', 'is_active', 'sort_order'], 'categories_type_active_sort_index');
                }
            });
        }

        // Languages table indexes
        if (Schema::hasTable('languages')) {
            Schema::table('languages', function (Blueprint $table) {
                if (!$this->hasIndex('languages', 'languages_code_index')) {
                    $table->index('code', 'languages_code_index');
                }
                if (!$this->hasIndex('languages', 'languages_is_active_index')) {
                    $table->index('is_active', 'languages_is_active_index');
                }
            });
        }

        // Episodes table indexes
        if (Schema::hasTable('episodes')) {
            Schema::table('episodes', function (Blueprint $table) {
                if (!$this->hasIndex('episodes', 'episodes_series_id_index')) {
                    $table->index('series_id', 'episodes_series_id_index');
                }
                if (!$this->hasIndex('episodes', 'episodes_status_index')) {
                    $table->index('status', 'episodes_status_index');
                }

                // Composite index for series episodes
                if (!$this->hasIndex('episodes', 'episodes_series_status_index')) {
                    $table->index(['series_id', 'status'], 'episodes_series_status_index');
                }
            });
        }

        // Favorites table indexes
        if (Schema::hasTable('favorites')) {
            Schema::table('favorites', function (Blueprint $table) {
                if (!$this->hasIndex('favorites', 'favorites_user_id_index')) {
                    $table->index('user_id', 'favorites_user_id_index');
                }

                // Composite index for polymorphic relationship
                if (!$this->hasIndex('favorites', 'favorites_favorable_type_id_index')) {
                    $table->index(['favorable_type', 'favorable_id'], 'favorites_favorable_type_id_index');
                }

                // Composite index for user favorites
                if (!$this->hasIndex('favorites', 'favorites_user_favorable_index')) {
                    $table->index(['user_id', 'favorable_type', 'favorable_id'], 'favorites_user_favorable_index');
                }
            });
        }

        // Downloads table indexes
        if (Schema::hasTable('downloads')) {
            Schema::table('downloads', function (Blueprint $table) {
                if (!$this->hasIndex('downloads', 'downloads_user_id_index')) {
                    $table->index('user_id', 'downloads_user_id_index');
                }

                // Composite index for polymorphic relationship
                if (!$this->hasIndex('downloads', 'downloads_downloadable_type_id_index')) {
                    $table->index(['downloadable_type', 'downloadable_id'], 'downloads_downloadable_type_id_index');
                }
            });
        }

        // User devices table indexes
        if (Schema::hasTable('user_devices')) {
            Schema::table('user_devices', function (Blueprint $table) {
                if (!$this->hasIndex('user_devices', 'user_devices_user_id_index')) {
                    $table->index('user_id', 'user_devices_user_id_index');
                }
                if (!$this->hasIndex('user_devices', 'user_devices_is_active_index')) {
                    $table->index('is_active', 'user_devices_is_active_index');
                }

                // Composite index for active user devices
                if (!$this->hasIndex('user_devices', 'user_devices_user_active_index')) {
                    $table->index(['user_id', 'is_active'], 'user_devices_user_active_index');
                }
            });
        }

        // Payment transactions table indexes
        if (Schema::hasTable('payment_transactions')) {
            Schema::table('payment_transactions', function (Blueprint $table) {
                if (!$this->hasIndex('payment_transactions', 'payment_transactions_user_id_index')) {
                    $table->index('user_id', 'payment_transactions_user_id_index');
                }
                if (!$this->hasIndex('payment_transactions', 'payment_transactions_status_index')) {
                    $table->index('status', 'payment_transactions_status_index');
                }
                if (!$this->hasIndex('payment_transactions', 'payment_transactions_created_at_index')) {
                    $table->index('created_at', 'payment_transactions_created_at_index');
                }

                // Composite index for user transactions
                if (!$this->hasIndex('payment_transactions', 'payment_transactions_user_status_index')) {
                    $table->index(['user_id', 'status'], 'payment_transactions_user_status_index');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop indexes from payment_transactions
        if (Schema::hasTable('payment_transactions')) {
            Schema::table('payment_transactions', function (Blueprint $table) {
                $table->dropIndex('payment_transactions_user_id_index');
                $table->dropIndex('payment_transactions_status_index');
                $table->dropIndex('payment_transactions_created_at_index');
                $table->dropIndex('payment_transactions_user_status_index');
            });
        }

        // Drop indexes from user_devices
        if (Schema::hasTable('user_devices')) {
            Schema::table('user_devices', function (Blueprint $table) {
                $table->dropIndex('user_devices_user_id_index');
                $table->dropIndex('user_devices_is_active_index');
                $table->dropIndex('user_devices_user_active_index');
            });
        }

        // Drop indexes from downloads
        if (Schema::hasTable('downloads')) {
            Schema::table('downloads', function (Blueprint $table) {
                $table->dropIndex('downloads_user_id_index');
                $table->dropIndex('downloads_downloadable_type_id_index');
            });
        }

        // Drop indexes from favorites
        if (Schema::hasTable('favorites')) {
            Schema::table('favorites', function (Blueprint $table) {
                $table->dropIndex('favorites_user_id_index');
                $table->dropIndex('favorites_favorable_type_id_index');
                $table->dropIndex('favorites_user_favorable_index');
            });
        }

        // Drop indexes from episodes
        if (Schema::hasTable('episodes')) {
            Schema::table('episodes', function (Blueprint $table) {
                $table->dropIndex('episodes_series_id_index');
                $table->dropIndex('episodes_status_index');
                $table->dropIndex('episodes_series_status_index');
            });
        }

        // Drop indexes from languages
        if (Schema::hasTable('languages')) {
            Schema::table('languages', function (Blueprint $table) {
                $table->dropIndex('languages_code_index');
                $table->dropIndex('languages_is_active_index');
            });
        }

        // Drop indexes from categories
        if (Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropIndex('categories_type_index');
                $table->dropIndex('categories_is_active_index');
                $table->dropIndex('categories_sort_order_index');
                $table->dropIndex('categories_type_active_sort_index');
            });
        }

        // Drop indexes from user_subscriptions
        if (Schema::hasTable('user_subscriptions')) {
            Schema::table('user_subscriptions', function (Blueprint $table) {
                $table->dropIndex('user_subscriptions_user_id_index');
                $table->dropIndex('user_subscriptions_plan_id_index');
                $table->dropIndex('user_subscriptions_status_index');
                $table->dropIndex('user_subscriptions_ends_at_index');
                $table->dropIndex('user_subscriptions_user_status_index');
            });
        }

        // Drop indexes from users
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropIndex('users_email_index');
                $table->dropIndex('users_status_index');
                $table->dropIndex('users_subscription_tier_index');
                $table->dropIndex('users_subscription_expires_at_index');
                $table->dropIndex('users_subscription_status_index');
            });
        }

        // Drop indexes from series
        if (Schema::hasTable('series')) {
            Schema::table('series', function (Blueprint $table) {
                $table->dropIndex('series_status_index');
                $table->dropIndex('series_category_id_index');
                $table->dropIndex('series_language_id_index');
                $table->dropIndex('series_subscription_tier_index');
                $table->dropIndex('series_status_subscription_tier_index');
                $table->dropIndex('series_category_status_index');
                $table->dropIndex('series_views_count_index');
                $table->dropIndex('series_rating_index');
            });
        }

        // Drop indexes from movies
        if (Schema::hasTable('movies')) {
            Schema::table('movies', function (Blueprint $table) {
                $table->dropIndex('movies_status_index');
                $table->dropIndex('movies_category_id_index');
                $table->dropIndex('movies_language_id_index');
                $table->dropIndex('movies_subscription_tier_index');
                $table->dropIndex('movies_release_year_index');
                $table->dropIndex('movies_status_subscription_tier_index');
                $table->dropIndex('movies_category_status_index');
                $table->dropIndex('movies_views_count_index');
                $table->dropIndex('movies_rating_index');
                $table->dropIndex('movies_created_at_index');
            });
        }
    }

    /**
     * Check if an index exists on a table
     */
    private function hasIndex(string $table, string $index): bool
    {
        $indexes = Schema::getConnection()
            ->getDoctrineSchemaManager()
            ->listTableIndexes($table);

        return array_key_exists($index, $indexes);
    }
};
