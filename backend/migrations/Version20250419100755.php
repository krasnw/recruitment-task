<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250419100755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE basic_data ALTER id DROP DEFAULT
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE basic_data ALTER created_at DROP DEFAULT
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE basic_data ALTER created_at SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contact_data DROP CONSTRAINT contact_data_basic_data_id_fkey
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_contact_data_basic_data_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contact_data ALTER id DROP DEFAULT
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contact_data ALTER created_at DROP DEFAULT
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contact_data ALTER created_at SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contact_data ADD CONSTRAINT FK_850C719CDB6F30F1 FOREIGN KEY (basic_data_id) REFERENCES basic_data (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_850C719CDB6F30F1 ON contact_data (basic_data_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE work_experience DROP CONSTRAINT work_experience_basic_data_id_fkey
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE work_experience ALTER id DROP DEFAULT
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE work_experience ALTER created_at DROP DEFAULT
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE work_experience ALTER created_at SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE work_experience ADD CONSTRAINT FK_1EF36CD0DB6F30F1 FOREIGN KEY (basic_data_id) REFERENCES basic_data (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER INDEX idx_work_experience_basic_data_id RENAME TO IDX_1EF36CD0DB6F30F1
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE work_experience DROP CONSTRAINT FK_1EF36CD0DB6F30F1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE work_experience_id_seq
        SQL);
        $this->addSql(<<<'SQL'
            SELECT setval('work_experience_id_seq', (SELECT MAX(id) FROM work_experience))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE work_experience ALTER id SET DEFAULT nextval('work_experience_id_seq')
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE work_experience ALTER created_at SET DEFAULT CURRENT_TIMESTAMP
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE work_experience ALTER created_at DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE work_experience ADD CONSTRAINT work_experience_basic_data_id_fkey FOREIGN KEY (basic_data_id) REFERENCES basic_data (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER INDEX idx_1ef36cd0db6f30f1 RENAME TO idx_work_experience_basic_data_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contact_data DROP CONSTRAINT FK_850C719CDB6F30F1
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_850C719CDB6F30F1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE contact_data_id_seq
        SQL);
        $this->addSql(<<<'SQL'
            SELECT setval('contact_data_id_seq', (SELECT MAX(id) FROM contact_data))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contact_data ALTER id SET DEFAULT nextval('contact_data_id_seq')
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contact_data ALTER created_at SET DEFAULT CURRENT_TIMESTAMP
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contact_data ALTER created_at DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contact_data ADD CONSTRAINT contact_data_basic_data_id_fkey FOREIGN KEY (basic_data_id) REFERENCES basic_data (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_contact_data_basic_data_id ON contact_data (basic_data_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE basic_data_id_seq
        SQL);
        $this->addSql(<<<'SQL'
            SELECT setval('basic_data_id_seq', (SELECT MAX(id) FROM basic_data))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE basic_data ALTER id SET DEFAULT nextval('basic_data_id_seq')
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE basic_data ALTER created_at SET DEFAULT CURRENT_TIMESTAMP
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE basic_data ALTER created_at DROP NOT NULL
        SQL);
    }
}
