/**
 * Dependency Injection Container
 *
 * Configure les dépendances entre les couches
 */

import { ProjectApiRepository } from '@/infrastructure/api/ProjectApiRepository';
import { SkillApiRepository } from '@/infrastructure/api/SkillApiRepository';
import { ContactApiRepository } from '@/infrastructure/api/ContactApiRepository';

import { GetProjects } from '@/application/useCases/project/GetProjects';
import { GetFeaturedProjects } from '@/application/useCases/project/GetFeaturedProjects';
import { GetProjectBySlug } from '@/application/useCases/project/GetProjectBySlug';
import { GetSkills } from '@/application/useCases/skill/GetSkills';
import { SendContactMessage } from '@/application/useCases/contact/SendContactMessage';

class Container {
    private instances = new Map();

    // Repositories
    private getProjectRepository() {
        if (!this.instances.has('ProjectRepository')) {
            this.instances.set('ProjectRepository', new ProjectApiRepository());
        }
        return this.instances.get('ProjectRepository');
    }

    private getSkillRepository() {
        if (!this.instances.has('SkillRepository')) {
            this.instances.set('SkillRepository', new SkillApiRepository());
        }
        return this.instances.get('SkillRepository');
    }

    private getContactRepository() {
        if (!this.instances.has('ContactRepository')) {
            this.instances.set('ContactRepository', new ContactApiRepository());
        }
        return this.instances.get('ContactRepository');
    }

    // Use Cases
    getGetProjects(): GetProjects {
        if (!this.instances.has('GetProjects')) {
            this.instances.set('GetProjects', new GetProjects(this.getProjectRepository()));
        }
        return this.instances.get('GetProjects');
    }

    getGetFeaturedProjects(): GetFeaturedProjects {
        if (!this.instances.has('GetFeaturedProjects')) {
            this.instances.set('GetFeaturedProjects', new GetFeaturedProjects(this.getProjectRepository()));
        }
        return this.instances.get('GetFeaturedProjects');
    }

    getGetProjectBySlug(): GetProjectBySlug {
        if (!this.instances.has('GetProjectBySlug')) {
            this.instances.set('GetProjectBySlug', new GetProjectBySlug(this.getProjectRepository()));
        }
        return this.instances.get('GetProjectBySlug');
    }

    getGetSkills(): GetSkills {
        if (!this.instances.has('GetSkills')) {
            this.instances.set('GetSkills', new GetSkills(this.getSkillRepository()));
        }
        return this.instances.get('GetSkills');
    }

    getSendContactMessage(): SendContactMessage {
        if (!this.instances.has('SendContactMessage')) {
            this.instances.set('SendContactMessage', new SendContactMessage(this.getContactRepository()));
        }
        return this.instances.get('SendContactMessage');
    }
}

export const container = new Container();
