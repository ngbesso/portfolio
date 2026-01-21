import React from 'react';
import { motion } from 'framer-motion';
import { Skill } from '@/domain/entities/Skill';

interface SkillBadgeProps {
    skill: Skill;
}

export function SkillBadge({ skill }: SkillBadgeProps) {
    const getColorClass = () => {
        if (skill.isExpert()) return 'border-purple-500 bg-purple-50 text-purple-700';
        if (skill.isAdvancedOrHigher()) return 'border-green-500 bg-green-50 text-green-700';
        return 'border-blue-500 bg-blue-50 text-blue-700';
    };

    return (
        <motion.div
            whileHover={{ scale: 1.05 }}
            className={`relative overflow-hidden rounded-lg border-2 p-4 transition-all ${getColorClass()}`}
        >
            <div className="flex items-center justify-between mb-2">
                <h4 className="font-semibold">{skill.name}</h4>
                <span className="text-xs font-medium">{skill.levelLabel}</span>
            </div>

            {/* Barre de progression */}
            <div className="h-2 w-full bg-gray-200 rounded-full overflow-hidden">
                <motion.div
                    initial={{ width: 0 }}
                    animate={{ width: `${skill.levelPercentage}%` }}
                    transition={{ duration: 1, ease: 'easeOut' }}
                    className={`h-full ${
                        skill.isExpert()
                            ? 'bg-purple-500'
                            : skill.isAdvancedOrHigher()
                                ? 'bg-green-500'
                                : 'bg-blue-500'
                    }`}
                />
            </div>

            <p className="text-xs mt-1 opacity-75">{skill.levelPercentage}%</p>
        </motion.div>
    );
}
