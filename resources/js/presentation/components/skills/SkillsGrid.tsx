import React from 'react';
import { SkillBadge } from './SkillBadge';
import { Skill } from '@/domain/entities/Skill';

interface SkillsGridProps {
    skillsByCategory: Map<string, Skill[]>;
}

export function SkillsGrid({ skillsByCategory }: SkillsGridProps) {
    return (
        <div className="space-y-12">
            {Array.from(skillsByCategory.entries()).map(([category, skills]) => (
                <div key={category}>
                    <h3 className="text-2xl font-bold text-gray-900 mb-6">{category}</h3>
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        {skills.map((skill) => (
                            <SkillBadge key={skill.id} skill={skill} />
                        ))}
                    </div>
                </div>
            ))}
        </div>
    );
}
